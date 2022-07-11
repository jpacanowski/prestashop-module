<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class MyFirstModule extends Module
{
    public function __construct()
    {
        $this->name = 'myfirstmodule';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Jakub Pacanowski';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('My First module');
        $this->description = $this->l('My first example module.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('MYFIRSTMODULE_NAME'))
            $this->warning = $this->l('No name provided');
    }

    public function install(): bool
    {
        return parent::install()
            && $this->registerHook('displayHome')
            && Configuration::updateValue('licznik', 0);
    }

    public function uninstall(): bool
    {
        return parent::uninstall()
            && Configuration::deleteByName('licznik');
    }

    public function hookDisplayHome(array $params)
    {
        if(Tools::getValue('controller') == 'index') {

            Configuration::updateValue('licznik',
                Configuration::get('licznik') + 1);

            return 'Wejścia: ' . Configuration::get('licznik');
        }
    }
}
