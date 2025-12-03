<?php

declare(strict_types=1);

namespace App\Identity\Presentation\Console;

use App\Identity\Application\Command\CreateUser\CreateUserCommand;
use App\Identity\Domain\Exception\EmailAlreadyExistsException;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateUserConsoleCommand extends Command
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:user:create')
            ->setDescription('Создать нового пользователя')
            ->addArgument('email', InputArgument::REQUIRED, 'Email пользователя')
            ->addArgument('password', InputArgument::REQUIRED, 'Пароль пользователя')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $command = new CreateUserCommand($email, $password);

        try {
            $userId = $this->commandBus->execute($command);
            $output->writeln(sprintf('Пользователь создан успешно. ID: %s', $userId->toString()));

            return Command::SUCCESS;
        } catch (EmailAlreadyExistsException $e) {
            $output->writeln(sprintf('<error>Ошибка: %s</error>', $e->getMessage()));

            return Command::FAILURE;
        } catch (\Throwable $th) {
            $output->writeln(sprintf('<error>Произошла ошибка: %s</error>', $th->getMessage()));

            return Command::FAILURE;
        }
    }
}
