<?php

declare(strict_types=1);

namespace Softspring\Component\Components\Tests\Twig;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Contracts\Translation\TranslatorInterface;
use Traversable;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Loader\ArrayLoader;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

final class TemplatesTest extends TestCase
{
    public function testBaseBootstrap5FallsBackToEnglishWithoutRequest(): void
    {
        $twig = $this->createTwig();

        $html = $twig->render('@SfsComponents/base.bootstrap5.html.twig', [
            'app' => new AppStub(null, new SessionStub()),
        ]);

        self::assertStringContainsString('<html lang="en"', $html);
        self::assertStringContainsString('/assets/build/manifest.json', $html);
    }

    public function testAdminBootstrap5DoesNotRequireLogoutRoute(): void
    {
        $twig = $this->createTwig();

        $html = $twig->render('@SfsComponents/layout/admin.bootstrap5.html.twig', [
            'app' => new AppStub(new RequestStub(), new SessionStub()),
            'admin_menu' => [],
        ]);

        self::assertStringNotContainsString('sfs_user_logout', $html);
        self::assertStringNotContainsString('>Logout<', $html);
    }

    public function testSemanticUiPagerUsesNextLinkRelation(): void
    {
        $twig = $this->createTwig(['list_route']);

        $html = $twig->render('@SfsComponents/paginator/pager.semantic-ui.html.twig', [
            'app' => new AppStub(new RequestStub(), new SessionStub()),
            'collection' => new PaginationStub(),
            'pagination_route' => 'list_route',
            'pagination_route_attributes' => [],
            'query_params' => [],
        ]);

        self::assertStringContainsString('rel="prev">Previous</a>', $html);
        self::assertStringContainsString('rel="next">Next</a>', $html);
    }

    public function testBootstrap4AlertsUseBootstrap4DismissMarkup(): void
    {
        $twig = $this->createTwig();

        $html = $twig->render('@SfsComponents/flash-messages/alerts.bootstrap4.html.twig', [
            'app' => new AppStub(new RequestStub(), new SessionStub([
                'success' => ['Saved'],
            ])),
        ]);

        self::assertStringContainsString('class="close"', $html);
        self::assertStringContainsString('data-dismiss="alert"', $html);
        self::assertStringNotContainsString('btn-close', $html);
    }

    /**
     * @param string[] $definedRoutes
     */
    private function createTwig(array $definedRoutes = []): Environment
    {
        $filesystemLoader = new FilesystemLoader([], __DIR__.'/../..');
        $filesystemLoader->addPath(__DIR__.'/../../templates', 'SfsComponents');

        $arrayLoader = new ArrayLoader([
            'base.html.twig' => "{% extends '@SfsComponents/base.bootstrap5.html.twig' %}",
        ]);

        $twig = new Environment(new ChainLoader([$arrayLoader, $filesystemLoader]));
        $twig->addExtension(new TranslationExtension(new IdentityTranslatorStub()));
        $twig->addExtension(new ComponentsTestExtension($definedRoutes));

        return $twig;
    }
}

final class ComponentsTestExtension extends AbstractExtension
{
    /**
     * @param string[] $definedRoutes
     */
    public function __construct(private readonly array $definedRoutes)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset', fn (string $path): string => '/assets/'.$path),
            new TwigFunction('route_defined', fn (string $route): bool => in_array($route, $this->definedRoutes, true)),
            new TwigFunction('active_for_routes', fn (): string => ''),
            new TwigFunction('sfs_user_is', fn (): bool => false),
            new TwigFunction('is_granted', fn (): bool => false),
            new TwigFunction('url', function (string $route, array $parameters = []): string {
                if (!in_array($route, $this->definedRoutes, true)) {
                    throw new RuntimeException(sprintf('Undefined route "%s".', $route));
                }

                return '/'.$route.([] === $parameters ? '' : '?'.http_build_query($parameters));
            }),
        ];
    }
}

final class IdentityTranslatorStub implements TranslatorInterface
{
    /**
     * @var array<string, string>
     */
    private array $messages = [
        'pager.prev' => 'Previous',
        'pager.next' => 'Next',
        'pager.total' => 'Total',
    ];

    public function getLocale(): string
    {
        return 'en';
    }

    public function trans(?string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
    {
        return null !== $id ? ($this->messages[$id] ?? $id) : '';
    }
}

final class AppStub
{
    public UserStub $user;

    public function __construct(public ?RequestStub $request, public SessionStub $session)
    {
        $this->user = new UserStub();

        if ($this->request instanceof RequestStub) {
            $this->request->session = $this->session;
        }
    }
}

final class UserStub
{
    public string $displayName = 'Test User';
}

final class RequestStub
{
    public ParameterBagStub $attributes;
    public ParameterBagStub $query;

    public function __construct(
        public string $locale = 'en',
        ?ParameterBagStub $attributes = null,
        ?ParameterBagStub $query = null,
        public ?SessionStub $session = null,
    ) {
        $this->attributes = $attributes ?? new ParameterBagStub();
        $this->query = $query ?? new ParameterBagStub();
    }
}

final class ParameterBagStub
{
    /**
     * @param array<string, mixed> $values
     */
    public function __construct(private readonly array $values = [])
    {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->values[$key] ?? $default;
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->values;
    }
}

final class SessionStub
{
    public FlashBagStub $flashBag;
    public FlashBagStub $flashbag;

    /**
     * @param array<string, list<string>> $messages
     */
    public function __construct(array $messages = [])
    {
        $this->flashBag = new FlashBagStub($messages);
        $this->flashbag = $this->flashBag;
    }

    public function has(): bool
    {
        return false;
    }

    public function get(): mixed
    {
        return null;
    }
}

final class FlashBagStub
{
    /**
     * @param array<string, list<string>> $messages
     */
    public function __construct(private readonly array $messages)
    {
    }

    /**
     * @return array<string, list<string>>
     */
    public function peekAll(): array
    {
        return $this->messages;
    }

    /**
     * @return array<string, list<string>>
     */
    public function all(): array
    {
        return $this->messages;
    }
}

final class PaginationStub implements IteratorAggregate, Countable
{
    public int $page = 2;
    public int $prevPage = 1;
    public int $nextPage = 3;
    public bool $isFirstPage = false;
    public bool $isLastPage = false;

    public function getIterator(): Traversable
    {
        return new ArrayIterator([]);
    }

    public function count(): int
    {
        return 0;
    }

    /**
     * @return array<int|null>
     */
    public function collapsedPages(int $maxPages = 7, bool $alwaysShowFirstAndLast = true): array
    {
        return [1, 2, 3];
    }
}
