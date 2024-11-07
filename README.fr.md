<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
</head>

<img src="logo.png" alt="My Logo" width="50" />

# Module Prestashop pour les liens vers les réseaux sociaux et messageries (lgf_socialfollow)
🇬🇧 [English](README.md)
## Description
Le `lgf_socialfollow` est une amélioration importante du module Prestashop original [`ps_socialfollow`](https://github.com/PrestaShop/ps_socialfollow). Il permet d'afficher des liens vers vos comptes sur les réseaux sociaux et les messageries, aidant ainsi vos clients à savoir où vous suivre et à développer votre communauté en ligne.
Le module prend en charge les plateformes suivantes :

<div class="social-list">
  <div class="social-item">
    <i class="fa-brands fa-facebook-f" style="color: #1877F2;"></i>
    <span>Facebook</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-threads" style="color: #000000;"></i>
    <span>Threads</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-x-twitter" style="color: #1DA1F2;"></i>
    <span>X</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-bluesky" style="color: #0080FF;"></i>
    <span>Bluesky</span>
  </div>
  <div class="social-item">
    <i class="fa-solid fa-rss" style="color: #FFA500;"></i>
    <span>RSS</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-youtube" style="color: #FF0000;"></i>
    <span>YouTube</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-pinterest-p" style="color: #E60023;"></i>
    <span>Pinterest</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-vimeo-v" style="color: #1AB7EA;"></i>
    <span>Vimeo</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-instagram" style="color: #C13584;"></i>
    <span>Instagram</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-linkedin-in" style="color: #0A66C2;"></i>
    <span>LinkedIn</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-tiktok" style="color: #010101;"></i>
    <span>TikTok</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-discord" style="color: #5865F2;"></i>
    <span>Discord</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-signal-messenger" style="color: #3A76F0;"></i>
    <span>Signal</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-telegram-plane" style="color: #0088CC;"></i>
    <span>Telegram</span>
  </div>
  <div class="social-item">
    <i class="fa-brands fa-whatsapp" style="color: #25D366;"></i>
    <span>WhatsApp</span>
  </div>
</div>

<style>
  .social-list {
    display: flex;
    flex-direction: column;
  }
  .social-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px; /* Space between each row */
  }
  .social-item i {
    font-size: 18px; /* Larger icon size */
    width: 35px; /* Fixed width to align icons */
  }
  .social-item span {
    color: #00000; /* Text color */
  }
</style>

## Fonctionnalités
- Utilise les icônes Font Awesome pour les logos des plateformes
- Styles CSS entièrement personnalisables
- Suit les meilleures pratiques des modules Prestashop
- Configuration centralisée pour les réseaux sociaux pris en charge
- Rendu basé sur des modèles pour une personnalisation flexible de l'interface
## Installation
1. Téléchargez le fichier ZIP du module à partir de la [page des versions](https://github.com/flaggalagga/lgf_socialfollow/releases).
2. Dans le panneau d'administration de votre Prestashop, accédez à la section "Modules" et cliquez sur "Télécharger un module".
3. Choisissez le fichier ZIP téléchargé et cliquez sur "Téléverser ce module".
4. Localisez le module "Liens vers les réseaux sociaux et messageries" dans la liste et cliquez sur "Installer".
5. Configurez les paramètres du module selon vos besoins, comme les liens vers les réseaux sociaux.
## Personnalisation
Vous pouvez personnaliser l'apparence du module en modifiant le fichier CSS situé à `lgf_socialfollow/views/css/lgf_socialfollow.css`.

Le module utilise également un fichier de modèle (`lgf_socialfollow.tpl`) pour le rendu de l'interface, qui peut être davantage personnalisé au besoin.
## Signalement des problèmes
Si vous rencontrez des problèmes ou avez des demandes de fonctionnalités, veuillez créer un nouveau problème sur le [dépôt GitHub](https://github.com/flaggalagga/lgf_socialfollow/issues).
## Contribution
Les contributions sont les bienvenues ! Si vous souhaitez contribuer à ce projet, veuillez suivre le workflow standard de GitHub :
1. Forkez le dépôt
2. Créez une nouvelle branche pour vos modifications
3. Effectuez vos modifications
4. Soumettez une pull request
## Licence
Ce module est sous licence [Licence MIT](LICENSE).