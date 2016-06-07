create database gestion_site;
use gestion_site;

CREATE TABLE IF NOT EXISTS `client` (
  `code_client` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `civilite` varchar(12) NOT NULL,
  `adresse` varchar(300) NOT NULL,
  `code_postal` int(5) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `pays` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  PRIMARY KEY (`code_client`),
  UNIQUE KEY `code_client` (`code_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `client` (`code_client`, `email`, `nom`, `prenom`, `civilite`, `adresse`, `code_postal`, `ville`, `pays`, `mdp`) VALUES
('dupont.robert@npdc.fr', 'dupont.robert@npdc.fr', 'DUPONT', 'Robert', 'Monsieur', '19, rue des Marronniers', 59650, 'Villeneuve d''Ascq', 'France', '25d55ad283aa400af464c76d713c07ad'),
('durand.martin@wan.fr', 'durand.martin@wan.fr', 'DURAND', 'Martin', 'Monsieur', '209, rue de la Bassée', 62000, 'ARRAS', 'France', '25d55ad283aa400af464c76d713c07ad'),
('johnny.clegg@my.fr', 'johnny.clegg@my.fr', 'CLEGG', 'johnny', 'Monsieur', '1, rue du paradis', 59000, 'Marseille', 'France', 'e10adc3949ba59abbe56e057f20f883e'),
('lemaire.michel@monsite.fr', 'lemaire.michel@monsite.fr', 'LEMAIRE', 'Michel', 'Monsieur', '1050 avenue de la Libération', 75016, 'PARIS', 'France', 'e10adc3949ba59abbe56e057f20f883e'),
('p@p.fr', 'p@p.fr', 'p', 'p', 'Monsieur', 'r', 12345, 'd', 'd', 'e10adc3949ba59abbe56e057f20f883e');


CREATE TABLE IF NOT EXISTS `commande` (
  `num_cde` int(8) NOT NULL AUTO_INCREMENT,
  `code_client` varchar(60) NOT NULL,
  `dt_cde` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`num_cde`),
  KEY `code_client` (`code_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;


INSERT INTO `commande` (`num_cde`, `code_client`, `dt_cde`) VALUES
(1, 'dupont.robert@npdc.fr', '2016-05-04 07:24:45'),
(3, 'durand.martin@wan.fr', '2016-05-16 14:42:24'),
(4, 'johnny.clegg@my.fr', '2016-05-23 18:55:25'),
(6, 'dupont.robert@npdc.fr', '2016-05-23 19:11:33'),
(8, 'lemaire.michel@monsite.fr', '2016-05-23 19:22:17');


CREATE TABLE IF NOT EXISTS `facture` (
  `num_facture` int(10) NOT NULL AUTO_INCREMENT,
  `num_cde` int(10) NOT NULL,
  `dt_facture` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `montant_total` decimal(10,2) NOT NULL,
  `reglement_OK` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`num_facture`),
  UNIQUE KEY `num_cde` (`num_cde`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;


INSERT INTO `facture` (`num_facture`, `num_cde`, `dt_facture`, `montant_total`, `reglement_OK`) VALUES
(1, 1, '2016-05-04 07:24:45', '3190.80', 1),
(3, 3, '2016-05-07 14:42:24', '910.80', 1),
(4, 4, '2016-05-23 18:55:25', '3190.80', 1),
(6, 6, '2016-05-23 19:11:33', '753.60', 1),
(8, 8, '2016-05-23 19:22:17', '517.20', 1);


CREATE TABLE IF NOT EXISTS `hierarchie_produits` (
  `code_n0` varchar(10) NOT NULL,
  `lib_n0` varchar(200) NOT NULL,
  `code_n1` varchar(10) NOT NULL,
  `lib_n1` varchar(200) NOT NULL,
  `code_n2` varchar(10) NOT NULL,
  `lib_n2` varchar(200) NOT NULL,
  PRIMARY KEY (`code_n0`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `panier` (
  `code_client` varchar(60) NOT NULL,
  `montant_total_ttc` decimal(10,2) NOT NULL,
  `dt_panier` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `panier` (`code_client`, `montant_total_ttc`, `dt_panier`) VALUES
('p@p.fr', '910.80', '2016-05-12 08:12:38');



CREATE TABLE IF NOT EXISTS `produit` (
  `code_prod` varchar(10) NOT NULL,
  `lib_prod` varchar(50) NOT NULL,
  `desc_court` varchar(100) NOT NULL,
  `desc_long` text NOT NULL,
  `dt_debut` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_fin` timestamp NOT NULL DEFAULT '2030-12-30 22:00:00',
  `prix_HT` decimal(10,2) NOT NULL,
  `TVA` decimal(4,2) NOT NULL,
  `commentaires` varchar(1000) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `stock_qte` int(5) NOT NULL,
  PRIMARY KEY (`code_prod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `produit` (`code_prod`, `lib_prod`, `desc_court`, `desc_long`, `dt_debut`, `dt_fin`, `prix_HT`, `TVA`, `commentaires`, `photo`, `stock_qte`) VALUES
('Ampli01', 'Amplificateur Denon AVR 2200', 'Ampli-tuner AV Denon AVR-X FM 2200 W Noir ', 'Ampli-tuner AV FM, 7 x 150 W', '2016-04-18 20:32:08', '2030-12-30 23:00:00', '759.00', '20.00', 'Puissance efficace avant 7 x 150 W\r\nRapport signal / bruit 100 dB \r\nRéponse en fréquence De 10 à 100000 Hz \r\nDécodeur intégré Décodeurs Dolby Atmos, DTS HD Master Audio et Dolby Digital \r\nTuner RDS \r\nCompatibilité DLNA Oui \r\nCompatible AirPlay Oui \r\nConnectivité Ethernet, Bluetooth, WiFi \r\nPort USB Oui', 'denon_avr_2200.jpg', 93),
('Audio01', 'AwoX StriimSOUND SD BW80', 'Enceinte Wifi Bluetooth', 'Avec AwoX StriimSOUND™, emplissez l’espace de musique issue de nombreuses sources:\r\nInternet, supports USB, bibliothèques DLNA, smartphones, tablettes et ordinateursnnnnnnnnnnnnn', '2015-12-22 11:42:51', '2030-12-30 22:00:00', '249.00', '20.00', 'striimSOUND_9767_web.jpgawoxcabasse60.jpgstriimSOUND_9767_web.jpgstriimSOUND_9767_web.jpgawoxcabasse60.jpg• Obtenez un son de très bonne qualité, compatible avec les formats MP3, AAC, WAV, PCM et FLAC.\r\n• Connectez-vous à votre réseau privé via le Wi-Fi ou un câble Ethernet (pour accéder à Internet, une connexion haut-débit est nécessaire), ou diffusez la musique directement depuis votre smartphone / tablette numérique via une connexion Bluetooth™ (profil Bluetooth A2DP requis).\r\n• Votre appareil mobile se transforme en véritable télécommande grâce à l’application AwoX gratuite pour iPhone®, iPod® touch, iPad® et Android®.\r\n• Boutons de réglage / désactivation du volume, synchronisation facile, sélection de la source, possibilité de pré-programmer 5 web radios, prise auxiliaire.\r\n• Adaptateur électrique fourni (alimentation 100-240 V)\r\n• Placement vertical ou horizontal, ingénierie acoustique signée Cabasse pour un son de haute qualité.\r\n• Combinez cette enceinte aux autres produits Aw', 'striimSOUND_9767_web.jpg', 98),
('HP01', 'Enceinte Cabasse MT32', 'Enceinte Colonne Cabasse Jersey MT32 Ebène à l''unité ', 'Enceinte colonne 2 voies, puissance 100 W, Sensibilité 89 dB \r\n', '2016-04-18 20:44:42', '2030-12-30 23:00:00', '475.00', '20.00', 'ombre de voies 2 \r\nTenue en puissance 100 W \r\nSensibilité 89 dB \r\nRéponse en fréquence De 57 à 23 000 Hz\r\nImpédance 8 Ohms\r\nCouleur ou finition Ebène \r\nCaractéristiques complémentaires \r\nHaut-parleur : Dome 27 mm, Grave : 2 x 17 cm 17TN15, Tweeter large-bande DOM 37 ; Filtre : 3500\r\nDimensions (l x p x h) en mm 250 x 350 x 996', 'enceintes_hifi_cabasse.jpg', 88),
('Photo01', 'Nikon D 5500', 'Appareil photo bridge', 'Reflex Nikon D5500 + Objectif AF-S 18-55 mm VR', '2015-12-15 09:26:42', '2020-12-15 09:26:42', '579.00', '20.00', 'Reflex Nikon D5500 + Objectif AF-S DX NIKKOR 18–55 mm VR II. Capteur CMOS 23,5 x 15,6 mm 24.7 Mpx. Viseur de type reflex avec pentamiroir à hauteur d''œil. Ecran TFT 3.2" affichant environ 1 037 000 pixels. WiFi intégré. ', 'Nikon5500.jpg', 100),
('Photo02', 'Canon EOS 750D', 'Appareil photo reflexReflex Canon EOS 750D + Objectif 18-55 mm IS STM ', 'Capteur CMOS 24,2 MP, Viseur de type pentamiroir, couverture environ 95% Relief oculaire : Environ 19 mm (depuis le centre de l''oculaire)', '2015-12-16 07:15:36', '2015-12-16 07:15:36', '759.00', '20.00', 'Un bon appareil pour débuter \r\nLa relève des Canons de moyennes gammes pour photographes amateurs éclairés est bien là. Il a une bonne prise en main, très réactif notamment dans le suivi de personnes ou animal bougeant. Son écran tactile, inclinable est un vrai plus. Sa fonction Wifi ', 'canon_eos_750d.jpg', 100),
('Photo03', 'Sony HX400V', 'Bridge numérique Sony Cyber-Shot DSC-HX400V noir ', 'Capteur : CMOS Exmor R 20,4 Mpx, Vidéo : Full HD 1080p, Ecran : LCD 7,5 cm 921600 points ', '2015-12-16 07:17:12', '2029-12-31 07:17:12', '352.00', '20.00', 'Un bon bridge polyvalent \r\nUn bridge efficace, zoom optique impressionnant. Bon résultat en mode automatique. photos très belles. Bonne prise en main. Autofocus réactif avec un léger bémol en basse luminosité. Menu simple d''accès, wifi pour transférer les photos pratique \r\n', 'SonyHX400v.jpg', 99),
('Photo04', 'Panasonic Lumix FZ 72', 'Bridge Numérique Panasonic Lumix DMC-FZ72 EF', 'Appareil Photo Numérique Bridge Panasonic DMC FZ72 EF-K Noir. Capteur MOS 16.1 Mpx haute Sensibilité. Objectif 60x F/2.8-5.9. Ultra grand angle 20mm. Vidéo Full HD 1080 50 images par seconde. Ecran 3" 460k points.', '2015-12-16 07:17:12', '2030-12-31 07:17:12', '549.00', '20.00', '', 'panasonic_lumix_FZ72.png', 99),
('Photo05', 'Fujifilm Instax mini 8 Bleu ', 'appareil numérique développement instantané', 'Léger et compact, le boîtier Fujifilm InstaxMini  8 va décupler votre plaisir de photographier…\r\nEn toutes circonstances, Visez, Appuyez et Obtenez en un instant, des tirages sur papier d’un souvenir, dans un format ludique et facile à partager.', '2015-12-16 07:17:12', '2030-12-31 07:17:12', '79.00', '20.00', '', 'polaroid_fuji_instant_8.jpg', 93),
('Photo06', 'Pentax K50', 'PENTAX k50 noir + smc da 17-70 f/4 sdm ', 'Le K-50 est équipé d''un capteur CMOS au format APS-C (23.7mm x 15.7mm). Ce capteur est couplé au processeur PRIME M, comme sur les modèles haut de gamme, afin de bénéficier d''une haute définition et d''images riches en détails grâce aux 16.28 mégapixels. Le K-50 offre également une plage de sensibilité allant jusqu''à 51200 ISO permettant à l''utilisateur de photographier à main levée des scènes en basse luminosité. ', '2015-12-20 19:20:15', '2030-12-30 22:00:00', '250.00', '20.00', 'Le PENTAX K-50 est le seul dans sa catégorie à bénéficier de caractéristiques techniques avancées telle qu''une cadence rafale à six images par seconde, une plage de sensibilité allant jusqu''à 51200 ISO et une précision extrême de la mise au point, notamment sur les sujets en mouvement. Que vous soyez photographe néophyte ou averti, le K-50 vous séduira par ses performances et sa simplicité d''utilisation. Le K-50, c''est aussi une construction sans compromis puisqu''il est tropicalisé et anti-poussières pour les utilisations en milieu hostile. De nombreuses fonctions sont disponibles sur le K-50, comme la vidéo Full HD, ainsi que de nombreux outils créatifs et une double alimentation par batterie Lithium ion ou piles types AA (avec le compartiment D-BH109 en option). ', 'pentax_k50.jpg', 100),
('Photo07', 'Nikon D5', 'Reflex Nikon D5 Boîtier Nu Monture Nikon F', 'Reflex Nikon D5, monture Nikon F, Capteur CMOS, 20.8 MP, Viseur de type reflex avec pentaprisme à hauteur d’œil', '2015-12-20 19:23:48', '2030-12-30 22:00:00', '6990.00', '20.00', 'Capteur CMOS-FX Nikon \r\nTaille du capteur 35.9 x 23.9 mm\r\nNombre de pixels 20,8 Millions pixels \r\nCompatibilité Haute Définition 4K \r\nMode rafale 12 vps au format FX en modes AE et AF, Jusqu''à 10 vps en mode CL, 10-12 vps ou 14 vps en mode CH avec levée du miroir (CH) ou 3 vps (mode continu silencieux) \r\nSensibilité ISO 100 à 102 400 ISO par incréments de 1/3, 1/2 ou 1 IL, réglable sur environ 0.3, 0.5, 0.7 ou 1 IL (équivalent à 50 ISO) en dessous de 100 ISO ou environ 0.3, 0.5, 0.7, 1, 2, 3, 4 ou 5 IL (équivalent à 3 280 000 ISO) au-dessus de 102 400 ISO\r\nMise au point Modes : AF point sélectif, AF zone dynamique 25, 72 ou 153 points, Suivi 3D, AF zone groupée, AF zone automatique', 'nikon_D5.jpg', 99),
('Photo08', 'Panasonic DMC-GF6', 'Panasonic dmc-gf6k appareil photo numérique compact 16 mpix wi-fi noir ', 'Appareil photo Hybride\r\nAppareil photo Hybride PANASONIC DMC-GF6 noir + 14-42 + 45-150mm + Sac+SD ', '2015-12-21 07:32:30', '2031-12-30 22:00:00', '467.00', '20.00', 'Panasonic DMC-GF6K. Mégapixel 16 MP, Type dappareil photo MILC, Type de capteur Live MOS. Zoom numérique 4x, Longueur focale 14 - 42 mm, Minimum distance focale (35mm equiv) 2.8 cm. Modes Auto Focusing (AF) auto focus continu, Face detection, Flexible Spot Auto Focus, auto focus individuel, Distance minimale de mise au point 0.2m. Sensibilité ISO 160, 200, 400, 800, 1600, 3200, 6400, 12800, 25600, Type dexposition priorité douverture AE, Auto, Manuel, priorité à la vitesse, Contrôle dexposition à la lumière Program AE. Vitesse dobturation de la caméra (min) 0.0000625s, Vitesse dobturation de la caméra (max) 60s', 'panasonic_dmc_gf6.jpg', 100);



CREATE TABLE IF NOT EXISTS `produits_commande` (
  `num_cde` int(8) NOT NULL,
  `code_prod` varchar(10) NOT NULL,
  `qte_cde` int(5) NOT NULL DEFAULT '0',
  `prix_HT` decimal(10,2) NOT NULL,
  `TVA` decimal(4,2) NOT NULL,
  PRIMARY KEY (`num_cde`,`code_prod`),
  KEY `code_prod` (`code_prod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `produits_commande` (`num_cde`, `code_prod`, `qte_cde`, `prix_HT`, `TVA`) VALUES
(1, 'Ampli01', 1, '759.00', '20.00'),
(1, 'HP01', 4, '475.00', '20.00'),
(3, 'Ampli01', 1, '759.00', '20.00'),
(4, 'Ampli01', 1, '759.00', '20.00'),
(4, 'HP01', 4, '475.00', '20.00'),
(6, 'Photo04', 1, '549.00', '20.00'),
(6, 'Photo05', 1, '79.00', '20.00'),
(8, 'Photo03', 1, '352.00', '20.00'),
(8, 'Photo05', 1, '79.00', '20.00');


CREATE TABLE IF NOT EXISTS `produits_panier` (
  `code_client` varchar(60) NOT NULL,
  `code_prod` varchar(10) NOT NULL,
  `qte` int(5) NOT NULL DEFAULT '0',
  `prix_HT` decimal(10,2) NOT NULL,
  `TVA` decimal(4,2) NOT NULL,
  PRIMARY KEY (`code_client`,`code_prod`),
  KEY `code_prod` (`code_prod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `produits_panier` (`code_client`, `code_prod`, `qte`, `prix_HT`, `TVA`) VALUES
('p@p.fr', 'Ampli01', 1, '759.00', '20.00');

CREATE TABLE IF NOT EXISTS `reglement` (
  `num_reglement` int(10) NOT NULL AUTO_INCREMENT,
  `num_facture` int(10) NOT NULL,
  `dt_reglement` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mode_reglement` varchar(10) NOT NULL,
  PRIMARY KEY (`num_reglement`),
  UNIQUE KEY `num_facture` (`num_facture`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;



INSERT INTO `reglement` (`num_reglement`, `num_facture`, `dt_reglement`, `mode_reglement`) VALUES
(1, 1, '2016-05-04 07:24:45', 'CB'),
(3, 3, '2016-05-07 14:42:24', 'CB'),
(4, 4, '2016-05-23 18:55:25', 'CB'),
(6, 6, '2016-05-23 19:11:33', 'CB'),
(8, 8, '2016-05-23 19:22:17', 'CB');


ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`code_client`) REFERENCES `client` (`code_client`);


ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`num_cde`) REFERENCES `commande` (`num_cde`);


ALTER TABLE `panier`
  ADD CONSTRAINT `fk_code_client` FOREIGN KEY (`code_client`) REFERENCES `client` (`code_client`);


ALTER TABLE `produits_commande`
  ADD CONSTRAINT `produits_commande_ibfk_1` FOREIGN KEY (`num_cde`) REFERENCES `commande` (`num_cde`),
  ADD CONSTRAINT `produits_commande_ibfk_2` FOREIGN KEY (`code_prod`) REFERENCES `produit` (`code_prod`);


ALTER TABLE `produits_panier`
  ADD CONSTRAINT `produits_panier_ibfk_1` FOREIGN KEY (`code_client`) REFERENCES `panier` (`code_client`),
  ADD CONSTRAINT `produits_panier_ibfk_2` FOREIGN KEY (`code_prod`) REFERENCES `produit` (`code_prod`);


ALTER TABLE `reglement`
  ADD CONSTRAINT `reglement_ibfk_1` FOREIGN KEY (`num_facture`) REFERENCES `facture` (`num_facture`);
