<?php

use EasyCorp\Bundle\EasyDeployBundle\Deployer\DefaultDeployer;

return new class extends DefaultDeployer
{
    public function configure()
    {
        return $this->getConfigBuilder()
            // SSH connection string to connect to the remote server (format: user@host-or-IP:port-number)
            ->server('root@134.209.219.72')
            // the absolute path of the remote server directory where the project is deployed
            ->deployDir('/var/www')
            // the URL of the Git repository where the project code is hosted
            ->repositoryUrl('git@github.com:antonch1989/erp.git')
            // the repository branch to deploy
            ->repositoryBranch('master')
            ->composerInstallFlags('--prefer-dist --no-interaction')
        ;
    }

    // run some local or remote commands before the deployment is started
    public function beforeStartingDeploy()
    {
        // $this->runLocal('./vendor/bin/simple-phpunit');
    }

    // run some local or remote commands after the deployment is finished
    public function beforeFinishingDeploy()
    {
        // $this->runRemote('{{ console_bin }} app:my-task-name');
        // $this->runLocal('say "The deployment has finished."');
    }

    public function beforePreparing()
    {
        $this->log('<h3>Copying over the .env files<h3/>');
        $this->runRemote('cp {{ deploy_dir }}/repo/.env {{ project_dir }}');
    }
};
