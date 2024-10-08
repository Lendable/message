<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message\Command\Naming;

use Lendable\Message\Command\Naming\ClassMapCommandNameResolver;
use Lendable\Message\Command\Naming\CommandNameNotResolvable;
use Lendable\Message\InvalidMessageName;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Lendable\Message\Command\ExampleBarCommand;
use Tests\Fixtures\Lendable\Message\Command\ExampleFooCommand;

#[CoversClass(ClassMapCommandNameResolver::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class ClassMapCommandNameResolverTest extends TestCase
{
    #[Test]
    public function resolves_name_for_known_commands(): void
    {
        $resolver = new ClassMapCommandNameResolver([ExampleBarCommand::class => 'command.bar']);

        self::assertSame('command.bar', $resolver->resolve(ExampleBarCommand::fresh())->toString());
    }

    #[Test]
    public function throws_for_unknown_command(): void
    {
        $resolver = new ClassMapCommandNameResolver([ExampleBarCommand::class => 'command.bar']);
        $command = ExampleFooCommand::fresh();

        $this->expectExceptionObject(CommandNameNotResolvable::for($command));

        $resolver->resolve($command);
    }

    #[Test]
    public function rethrows_invalid_name_as_resolving_failure(): void
    {
        $resolver = new ClassMapCommandNameResolver([ExampleBarCommand::class => ' ']);
        $error = null;

        try {
            $resolver->resolve(ExampleBarCommand::fresh());
        } catch (CommandNameNotResolvable $error) {
        }

        self::assertNotNull($error);
        self::assertInstanceOf(InvalidMessageName::class, $error->getPrevious());
    }
}
