<?php
/**
 * This module is based on ps_socialfollow
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * Modifications copyright (c) 2024 Lars FORNELL EI
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Validation;

class Lgf_Socialfollow extends Module implements WidgetInterface
{
    private const SOCIAL_NETWORKS = [
        'INSTAGRAM' => ['label' => 'Instagram', 'desc' => 'Your official Instagram account.'],
        'FACEBOOK' => ['label' => 'Facebook', 'desc' => 'Your Facebook fan page.'],
        'TIKTOK' => ['label' => 'TikTok', 'desc' => 'Your official TikTok account.'],
        'THREADS' => ['label' => 'Threads', 'desc' => 'Your official Threads account.'],
        'XTWITTER' => ['label' => 'X', 'desc' => 'Your official X account.'],
        'LINKEDIN' => ['label' => 'LinkedIn', 'desc' => 'Your official LinkedIn account.'],
        'BLUESKY' => ['label' => 'Bluesky', 'desc' => 'Your official Bluesky account.'],
        'BEHANCE' => ['label' => 'Behance', 'desc' => 'Your official Bēhance account.'],       
        'RSS' => ['label' => 'RSS', 'desc' => 'The RSS feed of your choice (your blog, your store, etc.).'],
        'YOUTUBE' => ['label' => 'YouTube', 'desc' => 'Your official YouTube account.'],
        'PINTEREST' => ['label' => 'Pinterest', 'desc' => 'Your official Pinterest account.'],
        'VIMEO' => ['label' => 'Vimeo', 'desc' => 'Your official Vimeo account.'],
        'DISCORD' => ['label' => 'Discord', 'desc' => 'Your official Discord account.'],
        'SIGNAL' => ['label' => 'Signal', 'desc' => 'Your official Signal account.'],
        'TELEGRAM' => ['label' => 'Telegram', 'desc' => 'Your official Telegram account.'],
        'WHATSAPP' => ['label' => 'WhatsApp', 'desc' => 'Your official WhatsApp account.']
    ];

    private $templateFile;

    public function __construct()
    {
        $this->name = 'lgf_socialfollow';
        $this->tab = 'advertising_marketing';
        $this->author = 'Lars FORNELL EI';
        $this->version = '1.0.0';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Social media and messengers links', [], 'Modules.Socialfollow.Admin');
        $this->description = $this->trans('Extensive upgrade to the original module ps_socialfollow, including Facebook, X, Signal, Telegram, let your customers know where to follow you and increase your community.', [], 'Modules.Socialfollow.Admin');
        $this->ps_versions_compliancy = ['min' => '1.7.4.0', 'max' => _PS_VERSION_];
        $this->templateFile = 'module:lgf_socialfollow/lgf_socialfollow.tpl';
    }

    public function install()
    {
        $result = parent::install() && 
                 $this->registerHook('actionFrontControllerSetMedia') && 
                 $this->registerHook('displayFooter');

        // Initialize configuration values
        foreach (array_keys(self::SOCIAL_NETWORKS) as $network) {
            $result &= Configuration::updateValue("LGF_SOCIAL_{$network}", '');
        }

        return $result;
    }

    public function uninstall()
    {
        $result = parent::uninstall();
        
        // Remove configuration values
        foreach (array_keys(self::SOCIAL_NETWORKS) as $network) {
            $result &= Configuration::deleteByName("LGF_SOCIAL_{$network}");
        }

        return $result;
    }

    protected function generateFormFields()
    {
        $inputs = [];
        foreach (self::SOCIAL_NETWORKS as $network => $info) {
            $inputs[] = [
                'type' => 'text',
                'lang' => true,
                'label' => $this->trans($info['label'] . ' URL:', [], 'Modules.Socialfollow.Admin'),
                'name' => "LGF_SOCIAL_{$network}",
                'desc' => $this->trans($info['desc'], [], 'Modules.Socialfollow.Admin'),
            ];
        }
        return $inputs;
    }

    public function renderForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => $this->trans('Settings', [], 'Admin.Global'),
                    'icon' => 'icon-cogs',
                ],
                'input' => $this->generateFormFields(),
                'submit' => [
                    'title' => $this->trans('Save', [], 'Admin.Global'),
                ],
            ],
        ];

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->submit_action = 'submitModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', true, [], ['configure' => $this->name]);
        $helper->tpl_vars = [
            'fields_value' => $this->getConfigFieldsValues(),
        ];
        $helper->languages = $this->context->controller->getLanguages();
        $helper->default_form_language = (int) $this->context->language->id;

        return $helper->generateForm([$fields_form]);
    }

    public function getConfigFieldsValues()
    {
        $result = [];
        foreach (array_keys(self::SOCIAL_NETWORKS) as $network) {
            $configName = "LGF_SOCIAL_{$network}";
            if (!empty(Configuration::get($configName))) {
                $this->upgradeConfiguration($configName);
            }
            foreach (Language::getIDs() as $idLang) {
                $result[$configName][$idLang] = Configuration::get($configName, $idLang);
            }
        }
        return $result;
    }

    protected function upgradeConfiguration($name)
    {
        $value = Configuration::get($name);
        if (!empty($value) && !is_array($value)) {
            $valueLocalized = array_fill_keys(Language::getIDs(), $value);
            Configuration::updateValue($name, $valueLocalized);
            return $valueLocalized;
        }
        return $value;
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $socialLinks = [];
        $idLang = (int) $this->context->language->id;

        foreach (self::SOCIAL_NETWORKS as $network => $info) {
            $value = Configuration::get("LGF_SOCIAL_{$network}", $idLang);
            if ($value) {
                $key = strtolower($network);
                $socialLinks[$key] = [
                    'label' => $this->trans($info['label'], [], 'Modules.Socialfollow.Shop'),
                    'class' => $key,
                    'url' => $value,
                ];
            }
        }

        return ['social_links' => $socialLinks];
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if (!$this->isCached($this->templateFile, $this->getCacheId('lgf_socialfollow'))) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }
        return $this->fetch($this->templateFile, $this->getCacheId('lgf_socialfollow'));
    }

    public function hookActionFrontControllerSetMedia()
    {
        $this->context->controller->registerStylesheet(
            'lgf_socialfollow_icons',
            '/modules/' . $this->name . '/views/css/lgf_socialfollow.css'
        );
    }

    protected function updateFields()
    {
        $validator = Validation::createValidator();
        $constraints = [new Url()];
        $values = [];
        $errors = [];

        foreach (array_keys(self::SOCIAL_NETWORKS) as $network) {
            foreach (Language::getIDs() as $idLang) {
                $fieldName = "LGF_SOCIAL_{$network}_{$idLang}";
                $values[$network][$idLang] = trim(Tools::getValue($fieldName, ''));
                
                if (!empty($values[$network][$idLang])) {
                    $violations = $validator->validate($values[$network][$idLang], $constraints);
                    if (count($violations)) {
                        $errors[] = $this->trans('Invalid URL', [], 'Admin.Notifications.Error') . 
                                  ': ' . $values[$network][$idLang];
                    }
                }
            }
        }

        if (empty($errors)) {
            foreach (array_keys(self::SOCIAL_NETWORKS) as $network) {
                Configuration::updateValue("LGF_SOCIAL_{$network}", $values[$network]);
            }
            return true;
        }

        return $errors;
    }

    public function getContent()
    {
        $html = '';
        if (Tools::isSubmit('submitModule')) {
            $result = $this->updateFields();
            if ($result === true) {
                $this->_clearCache('*');
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true, [], [
                    'configure' => $this->name,
                    'conf' => 4,
                ]));
            } else {
                $html .= $this->displayError(implode('<br />', $result));
            }
        }

        if (Shop::isFeatureActive() && Shop::getContext() != Shop::CONTEXT_SHOP) {
            $html .= '<p class="alert alert-warning">' .
                $this->trans('Please choose a shop to edit the social media links.', [], 'Modules.Socialfollow.Admin') .
                '</p>';
        } else {
            $html .= $this->renderForm();
        }

        return $html;
    }

    public function _clearCache($template, $cacheId = null, $compileId = null)
    {
        parent::_clearCache($this->templateFile);
    }
}