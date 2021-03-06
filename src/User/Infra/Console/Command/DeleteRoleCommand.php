<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Console\Command;

use MsgPhp\User\Command\DeleteRoleCommand as DeleteRoleDomainCommand;
use MsgPhp\User\Event\RoleDeletedEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class DeleteRoleCommand extends RoleCommand
{
    protected static $defaultName = 'role:delete';

    /** @var StyleInterface */
    private $io;

    public function onMessageReceived($message): void
    {
        if ($message instanceof RoleDeletedEvent) {
            $this->io->success('Deleted role '.$message->role->getName());
        }
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setDescription('Delete a role');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        $role = $this->getRole($input, $this->io);

        if ($input->isInteractive()) {
            $this->io->note('Deleting role '.$role->getName());

            if (!$this->io->confirm('Are you sure?')) {
                return 0;
            }
        }

        $this->dispatch(DeleteRoleDomainCommand::class, [$role->getName()]);

        return 0;
    }
}
