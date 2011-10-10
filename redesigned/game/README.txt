__   __ _   _
\ \ / /| \ | |
 \ V / |  \| | _____   ____ _
 /   \ | . ` |/ _ \ \ / / _` |
/ /^\ \| |\  | (_) \ V / (_| |
\/   \/\_| \_/\___/ \_/ \__,_|



LICENCE
=======
G.N.U.
(Please read LICENCE.txt for more informations)


INFORMATIONS
============
OGame Script based on UGamela
Developed by XNova Team


LINK
====
Site:    http://www.xnova.fr/
Forum:   http://www.xnova.fr/forum
SVN:     http://www.assembla.com/wiki/show/bZlv6KX3ar3jhJabIlDkbG/


CHARTER
=======
(Only in french)
[Présentation]
XNova est un projet libre et gratuit de serveur de jeu web multiplateforme (Windows, Linux, Mac, etc...).
Le serveur proprement dit est installable sur n'importe quel serveur Apache. Le joueur lui, n'aura besoin d'utiliser qu'un navigateur web (Internet Explorer, Mozilla Firefox, Netscape, etc...). Le jeu à pour thème la guerre et l'espace, et est, sur le fond, comparable au célèbre Starcraft (version logicielle développée par Blizzard Entertainment). Le but est, sur une planète donnée à l'inscription, d'établir une base en construisant des bâtiments (plus ou moins efficace en fonction de leur niveau d'amélioration) grâce à des ressources énergétiques et minérales (variables principalement selon les bâtiments). Grâce à la base construite, le joueur aura accès à la création de vaisseaux de combat et de défense dont il usera pour se déplacer, attaquer un autre joueur ou s'en défendre. A chaque combat entre les joueurs, des points et des ressources sont réparties. Afin d'être supérieur à son adversaire, le joueur devra faire preuve de stratégie en gérant ses ressources, son énergie, l'évolution de ses bâtiments, des technologies, et l'organisation de ses flottes.
En somme, XNova est un jeu MMOSTR ce qui signifie principalement que les joueurs interagissent entres eux. Un nouveau monde virtuel est donc à découvrir!
Pour installer XNova vous devez posséder:
    * Un serveur Apache avec PHP 4.x (minimum).
    * L'option mail() active (recommandé) et short open tags activé.
    * Une base de donnée MySQL (ou Postgre).
    * Des droits d'accès sur les fichiers (possibilité de changer le CHMOD)
XNova utilise quatre langages de programmation web:
    * PHP
    * Javascript
    * SQL
    * Ajax


[Distributions]
Avant tout, il est nécessaire de comprendre que XNova n'est pas un repack (c'est-à-dire qu'il ne s'agit pas d'un mix de plusieurs bouts de codes trouvés à droite et à gauche). L'équipe à l'ambition de reforger complètement un nouveau noyau, il s'agit donc d'un tout autre système de jeu.
Les membres de l'équipe d'XNova travaillent en commun sur un système de subversion (dit SVN) afin de faciliter les échanges et la modification des sources. Cependant, le subversion est devenu privé à cause du nombre croissant de problèmes liés aux voles et aux modifications barbares du code source qui commencent déjà à circuler sur internet.
Nous assurerons donc des mises-à-jour quotidienne sous forme d'archives compressées qui seront postées régulièrement sur le forum (partie release). Il est important que tout ce qui soit relatif à XNova soit centralisé sur le forum officiel. Si vous avez donc la moindre question ou suggestion, n'hésitez pas à poster. Il en est de même pour signaler un bug ou bien proposer une solution pour en résoudre un (dit un fix).


[Fonctionnement]
Différents type des fichiers sont présents dans le dossier qui compose le jeu. Voici donc quelles sont leurs utilités.
    * Admin (fichiers PHP): code source de la partie administrateur.
    * CSS (fichiers CSS): contenant le style de base et régie la structure des cadres.
    * DB (fichiers PHP): permet l'utilisation de requêtes SQL sur votre base de donnée.
    * Images (fichiers GIF, PNG, JPG): images de base, smileys, background de la page de connexion.
    * Includes (fichiers PHP): contenant diverses variables incluses dans les sources ainsi que les fonctions.
    * Install (fichiers PHP): permet l'édition du fichier config.php ainsi que l'installation de la base de donnée.
    * Language (fichiers MO): Tout les textes affichés sont contenus dans ces fichiers, facilite la traduction.
    * Scripts (fichiers JS): contenant certaines actions gérées en javascript.
    * Skins (fichiers CSS, GIF, JPG, PNG): contient le design, permet aux joueurs de choisir la façon dont sont affichées les pages (images, couleurs des cadres, etc...).
    * Templates (fichiers TPL): gèrent la structure des pages, essentiellement les cadres, programmés en HTML.
    * A la racine (fichiers PHP): code source du serveur (côté joueur), permet l'interaction entre les fonctions, les variables, la base de donnée, les actions javascript, le template, le skin et le texte affiché.
Il est nécessaire de préciser quelques points:
    * Les fichiers sources à la racine et dans le dossier admin possèdent chacun un template et utilisent tous les textes des fichiers langues. Aucun texte ou code HTML n'est contenu dans ces fichiers!
    * Il est possible de traduire le contenu d'XNova en copier le dossier fr, en le renommant avec les initiales de la langue dans laquelle sera traduit les textes, et enfin d'éditer les fichiers MO le contenant.
    * Seul le fichier config.php contient les informations de votre base de donnée.


[Services]
Avant tout, l'équipe d'XNova propose un service gratuit, il faut donc vous dire qu'ils n'ont aucune obligation envers les créateurs de serveurs et qu'ils ne sont pas à leur disposition. Dans le cas d'un problème avec un membre du forum, il sera normal qu'il soit sanctionné (exemple: bannissement) et devra donc se débrouiller seul.
Autrement, XNova propose son forum comme terrain d'entre-aide. Il vous est possible de poster vos questions et vos suggestions. Bien entendu, en cas de problème, vous pouvez poster dans la section appropriée et un membre de l'équipe ou du forum tentera d'y répondre.
Du côté du contenu d'XNova, l'équipe fait de son mieux pour apporter des mises-à-jours régulières et de résoudre le plus de problèmes possible.
De plus, outre le fait de corriger des problèmes, nous innovons sur le plan du jeu. En effet, l'équipe proposera de temps en temps une nouvelle fonction au jeu (nouveaux bâtiments, vaisseaux, technologies, etc...) ainsi que de nouveaux systèmes (officiers, colonisations, etc...).
XNova continuera de d'exister jusqu'à ce que les bugs soient corrigés et que l'imagination des programmeurs soient épuisées. Autant dire qu'il reste encore quelques années de travail avant de rendre XNova parfait.


[Obligations]
XNova est sous licence GNU GPL (GNU General Public License), ce qui implique:
    * Une liberté d'utiliser XNova, pour la création d'un serveur.
    * Une liberté d'étudier son fonctionnement et de l'adapter à ses besoins.
    * Une liberté de redistribuer des copies (non modifiées bien sur) en indiquant l'adresse du site officiel.
    * Une liberté d'améliorer et de rendre publiques les modifications afin que l'ensemble de la communauté en bénéficie.
    * Une interdiction d'user d'XNova pour un but commercial.
    * Une interdiction de supprimer les copyright des membres de l'équipe.
Du côté moral, vous avez tout de même certaines obligations:
    * Signaler un bug ou une faille de sécurité.
    * Après résolution d'un bug, communiquer la solution aux membres.
    * Ne pas s'attribuer les mérites du travail de l'équipe d'XNova.
    * Avant téléchargement et utilisation, vous devez avoir lu cette charte et être en accord avec tout les points qui la constitue.