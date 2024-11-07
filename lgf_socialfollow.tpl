{**
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
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    Lars FORNELL EI @flaggalagga
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @copyright 2024 Lars FORNELL EI
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}

{block name='lgf_social_follow'}
  <div class="lgf-social-follow col-lg-4 col-md-12 col-sm-12">
    <h4>{l s='Follow us' d='Modules.Socialfollow.Shop'}</h4>
    <ul>
      {foreach from=$social_links item='social_link'}
        <li class="{$social_link.class}"><a href="{$social_link.url}">{$social_link.label}</a></li>
      {/foreach}
    </ul>
  </div>
{/block}
