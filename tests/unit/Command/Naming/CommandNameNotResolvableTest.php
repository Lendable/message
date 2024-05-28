<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message\Command\Naming;

use Lendable\Message\Command\Command;
use Lendable\Message\Command\Naming\CommandNameNotResolvable;
use Lendable\Message\CorrelationId;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Lendable\Message\Command\ExampleFooCommand;

#[CoversClass(CommandNameNotResolvable::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class CommandNameNotResolvableTest extends TestCase
{
    #[Test]
    public function it_can_be_constructed_from_an_command(): void
    {
        $command = ExampleFooCommand::fresh(CorrelationId::generate());
        $exception = CommandNameNotResolvable::for($command);

        self::assertSame($this->expectedExceptionMessage($command), $exception->getMessage());
        self::assertNull($exception->getPrevious());
    }

    #[Test]
    public function it_can_be_constructed_from_an_command_and_triggering_throwable(): void
    {
        $command = ExampleFooCommand::fresh(CorrelationId::generate());
        $previous = new \RuntimeException();
        $exception = CommandNameNotResolvable::for($command, $previous);

        self::assertSame($this->expectedExceptionMessage($command), $exception->getMessage());
        self::assertSame($previous, $exception->getPrevious());
    }

    private function expectedExceptionMessage(Command $command): string
    {
        return \sprintf('Command message name for %s<%s> could not be resolved.', $command::class, $command->id()->toString());
    }
}
