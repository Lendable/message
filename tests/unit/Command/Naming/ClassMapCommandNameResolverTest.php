<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message\Command\Naming;

use Lendable\Message\Command\Naming\ClassMapCommandNameResolver;
use Lendable\Message\Command\Naming\CommandNameNotResolvable;
use Lendable\PHPUnitExtensions\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures\Lendable\Message\Command\ExampleBarCommand;
use Tests\Fixtures\Lendable\Message\Command\ExampleFooCommand;

#[CoversClass(ClassMapCommandNameResolver::class)]
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
}
