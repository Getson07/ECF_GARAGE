<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\CarCaracteristic;
use App\Entity\EquipmentOptions;
use App\Entity\Model;
use App\Entity\Service;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

class AppFixtures extends Fixture
{
    private const FIAT_500_REFERENCE = 'fiat_500';
    private const NISSAN_QUASQUAI_REFERENCE = 'nissan_qashqai';
    private const AUDI_S1_REFERENCE = 'audi_s1';
    private const PORSCHE_CAYENNE_REFERENCE = 'prosche_cayenne';
    private const AUDI_Q3_REFERENCE = 'audi_q3';
    private const VOLKSWAGEN_TROC_REFERENCE = 'volkswagen_troc';

    public function load(ObjectManager $manager): void
    {
        /**Création du catalogue de marque et de modèle */
        $catalogue = [
            'Renault' => ['4Ever', 'Alaskan', 'Austral','Captur','Clio','Clio R.S.','Espace','Fluence','Kadjar', 'Kangoo', 'Koleos'],
            'Peugeot' => ['1007','107','108','2008','206','207','208','208 GTi','3008','307','308','308 GTi','4007','407','408','5008','508','897'],
            'Citroen' => ['Ami','Berlingo','C SportLounge Concept','C-Crosser','C-Zero','C1','C3','C3 Aircross','C4','C4 Cactus','C4 X','C5','C5 Aircross','C5 X','C6','E-Mehari','Nemo',], 
            'Volkswagen' => ['Amarok','Arteon','Caddy','T-ROC','California','Eos','Fox','Golf','Golf GTI','ID.3','ID.4','ID.5','ID.7','ID.BUZZ','Jetta','Multivan','New Beetle','Nouvelle Coccinelle (Beetle)','Passat','Polo','Scirocco','Sharan',], 
            'Dacia' => ['Bigster','Dokker','Duster','Jogger','Lodgy','Logan','Sandero','Spring',],
            'Toyota' => ['Auris','Avensis','Aygo','bZ4X','C-HR','Camry','Corolla','GR 86','GT86','Highlander','Hilux','IQ','Land Cruiser','Mirai','Prius','RAV4','Supra','Urban Cruiser',], 
            'Ford' => ['B-Max','Bronco','C-Max','EcoSport','Edge','Escape','Explorer','F150','Fiesta','Focus','Focus RS','Focus ST','Galaxy','GT','Ka','Kuga','Mondeo','Mustang','Mustang Mach-E','Puma','Ranger','S-Max','Transit',], 
            'Opel' => ['Adam','Agila','Ampera E','Antara','Astra','Cascada','Combo Life','Corsa','Crossland','Grandland','GT','Insignia','Karl','Manta GSE','Meriva','Mokka','Rocks-e','Tigra','Zafira',],
            'Nissan' => ['350Z','370Z','Ariya','Cube','GT-R','Juke','Leaf','Micra','Mixim Concept','Murano','Navara','Note','NV200','Pathfinder','Patrol','Pixo','Pulsar','Qashqai','Terranaut Concept','Titan','X-TRAIL','Z Coupé',], 
            'Fiat' => ['124 Spider','500','500e','500X','600','Bravo','Croma','Doblo','Fiorino','Freemont','Panda','Punto','Sedici','Stilo','Tipo','Topolino',], 
            'Mercedes' => ['AMG GT','AMG One','Citan','CL','CLA','Classe A','Classe B','Classe C','Classe E','Classe G','Classe G','Classe M','Classe M','Classe R','Classe S','Classe V','Classe X','CLE','CLK','CLS',], 
            'Audi' => ['A1','A3','S1','A4','A5','A6','A7','A8','e-tron GT','Q2','Q3','Q4 e-tron','Q5','Q6 e-tron','Q7','Q8','Q8 e-tron','R8','RS 3','RS 4','RS Q3','RS Q8','RS5','RS6','RS7 Sportback','S3','S5','TT',], 
            'BMW' => ['i3','i4','i5','i7','i8','iX','iX3','M2','M3','M4','M5','M8','Série 1','Série 2','Série 3','Série 4','Série 5','Série 6','Série 7','Série 8','X1','X2','X3','X4','X5','X6','X7','XM','Z4',], 
            'Kia' => ['Carens','Carnival','Ceed','EV6','EV9','Forte','Magentis','Niro','Optima','Picanto','ProCeed','Rio','Sorento','Soul','Sportage','Stinger','Stonic','Venga','Xceed',], 
            'Hyundai' => ['Azera','Bayon','Genesis','i10','i20','i30','i30 N','i40','Ioniq','Ioniq 5','Ioniq 6','ix20','ix35','Kona','Nexo','Santa Fe','Tucson','Veloster',], 
            'Porsche' => ['356','718','911','935','Boxster','Carrera GT','Cayenne','Cayman','Macan','Panamera','Taycan',],
        ];
        
        foreach ($catalogue as $brand_name => $models) {
            $brand = new Brand();
            $brand->setName($brand_name);
            foreach ($models as $model_name) {
                $model = new Model();
                $model->setName($model_name);
                $model->setBrand($brand);
                $manager->persist($model);
                $brand->addModel($model);
                /**Ajout des références de modèles afin de pouvoir les liés aux différentes voiture*/
                $car_fullname = strtoupper($brand_name.'_'.$model_name);
                switch ($car_fullname) {
                    case 'FIAT_500':
                        $this->addReference(self::FIAT_500_REFERENCE, $model);
                        break;
                    case 'NISSAN_QASHQAI':
                        $this->addReference(self::NISSAN_QUASQUAI_REFERENCE, $model);
                        break;
                    case 'VOLKSWAGEN_T-ROC':
                        $this->addReference(self::VOLKSWAGEN_TROC_REFERENCE, $model);
                        break;
                    case 'AUDI_S1':
                            $this->addReference(self::AUDI_S1_REFERENCE, $model);
                            break;
                    case 'PORSCHE_CAYENNE':
                        $this->addReference(self::PORSCHE_CAYENNE_REFERENCE, $model);
                        break;            
                    case 'AUDI_Q3':
                        $this->addReference(self::AUDI_Q3_REFERENCE, $model);
                        break;
                }
            }
            $manager->persist($brand);
        }

        /** Créer un Nouvel Utilisateur administrateur */
        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'sodium' => ['algorithm' => 'sodium'],
        ]);
        $passwordHasher = $factory->getPasswordHasher('common');
        $admin = new User();
        $admin->setFirstname('Victor');
        $admin->setLastname('Parrot');
        $admin->setEmail('v.parrot@admin.com');
        $admin->setGender('Homme');
        $admin->setPassword($passwordHasher->hash('v.p@rrot280'));
        $admin->setDateOfBirth(new \DateTime('1980-06-30'));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        /**Créer des voitures qui seront raccordés à cet utilisateur comme poster */
        $cars = [
            'FIAT_500' => [
                'name' => 'FIAT 500 II 1.4 16V 100 LOUNGE',
                'images' => ['fiat500_1.jpg', 'fiat500_2.jpg', 'fiat500_3.jpg', 'fiat500_4.jpg', 'fiat500_5.jpg'],
                'price' => '7 990',
                'fiscal_power' => '6 CV',
                'engine_power' => '(DIN) 101 ch - (moteur) 74 kW Consommation',
                'euro_standard' => 'EURO4',
                'crit_air' => '2',
                'combined_consumption' => '5,2 L/100 km',
                'co2_emission' => 'D',
                'posted_at' => date('now'),
                'poster' => $admin,
                'model' => ''/**Trouver le modèle correspondant */,
                'characteristics' => [
                    'year_of_launch' => '26-03-2009',
                    'origin' => 'France',
                    'technichal_control' => 'Requis',
                    'first_hand' => 'Non',
                    'energy' => 'Essence',
                    'gearbox' => 'Manuelle',
                    'color' => 'jaune metalSellerie',
                    'number_of_doors' => '3',
                    'number_of_seats' => '4',
                    'length' => '3,55 m',
                    'trunk_volume' => 'Moyen Coffre',
                    'related_car' => '',
                ],
                'equipmentOptions' => [
                    'exterior_and_chassis' => ['Ampoules de phares halogènes','Antibrouillards avant','Becquet'],
                    'interior' => ['Volant cuir','Système audio CD','Ordinateur de bord','Air conditionné manuel','Ouverture du coffre à distance',
                                    'Système audio lecteur CD et MP3','Volant multi-fonction','6 haut-parleurs','Réglage du volant en hauteur'
                                ],
                    'security' => ['ESP','Airbags rideaux','Antipatinage','ABS','Airbags latéraux'],
                    'security_lock' => '',
                    'related_car' => '',
                ]


            ],
            'VOLKSWAGEN_TROC' => [
                'name' => 'VOLKSWAGEN T-ROC 2.0 TSI 190 CARAT 4MOTION DSG7',
                'images' => ['volks1.jpg', 'volks2.jpg', 'volks3.jpg', 'volks4.jpg', 'volks5.jpg'],
                'price' => '27 990',
                'fiscal_power' => '11 CV',
                'engine_power' => '(DIN) 190 ch - (moteur) 140 kW',
                'euro_standard' => 'EURO6',
                'crit_air' => '1',
                'combined_consumption' => '5,8 L/100 km',
                'co2_emission' => 'D',
                'posted_at' => date('now'),
                'poster' => $admin,
                'model' => ''/**Trouver le modèle correspondant */,
                'characteristics' => [
                    'year_of_launch' => '26-04-2018',
                    'origin' => 'Importé',
                    'technichal_control' => 'Requis',
                    'first_hand' => 'Non',
                    'energy' => 'Essence',
                    'gearbox' => 'Automatique',
                    'color' => 'blanc metalSellerie',
                    'number_of_doors' => '5',
                    'number_of_seats' => '5',
                    'length' => '4,23 m',
                    'trunk_volume' => 'Moyen Coffre',
                    'related_car' => '',
                ],
                'equipmentOptions' => [
                    'exterior_and_chassis' => [
                        'Rétroviseurs extérieurs réglage électrique','Feux de route à LED','Phares à allumage automatique','Rétroviseurs extérieurs chauffants','Freins régénérateurs','Feux arrières à LED','Feux de croisement automatiques','Rétroviseurs rabattables électriquement','Antibrouillards avant','Aide parking av/ar','Barres de toit','Becquet','Étriers de freins rouges','Frein de parking automatique','Jantes alu 18"','Pack visibilité','Projecteurs bi-xénon','Radar de recul','Rétroviseurs électriques et dégivrants','Rétroviseurs rabattables'
                    ],
                    'interior' => [
                        'Volant cuir','Système audio écran tactile, carte digitale','Bouton démarrage','Information trafic','Ordinateur de bord','Air conditionné auto','Tapis de sol','Système de navigation','Taille écran navigation 8 pouces','Accoudoir central arrière, avant','Limiteur de vitesse','Rétroviseur jour/nuit','Volant multi-fonction','Bluetooth inclut musique en streaming, connexion téléphone','Régulateur de vitesse adaptatif','Bluetooth'
                    ],
                    'security' => [
                        '6 airbags','ESP','Airbags rideaux','Détection panneaux signalisation','Antipatinage','Système détection de collision','Capteur d\'angle mort','Indicateur de sous-gonflage des pneus','Assistance au freinage d\'urgence','ABS','Avertisseur de franchissement de ligne','Airbags latéraux','Kit anticrevaison','Essuie glace capteur de pluie','Aide au démarrage en côte','Contrôle de pression des pneus','Feux et essuie-glaces automatiques','Système de détection de somnolence','Système de vision de nuit',
                    ],
                    'security_lock' => '',
                    'related_car' => '',
                ]


            ],
            'AUDI_S1' => [
                'name' => 'AUDI S1 SPORTBACK 2.0 TFSI 231',
                'images' => ['audiS1_1.jpg', 'audiS2_1.jpg', 'audiS3_1.jpg','audiS4_1.jpg', 'audiS5_1.jpg'],
                'price' => '21 990',
                'fiscal_power' => '14 CV',
                'engine_power' => '(DIN) 231 ch - (moteur) 170 kW',
                'euro_standard' => 'EURO5',
                'crit_air' => '1',
                'combined_consumption' => '7,2 L/100 km',
                'co2_emission' => 'E',
                'posted_at' => date('now'),
                'poster' => $admin,
                'model' => ''/**Trouver le modèle correspondant */,
                'characteristics' => [
                    'year_of_launch' => '15-10-2014',
                    'origin' => 'Importé',
                    'technichal_control' => 'Requis',
                    'first_hand' => 'Non',
                    'energy' => 'Essence',
                    'gearbox' => 'Manuelle',
                    'color' => 'gris foncé metalSellerie',
                    'number_of_doors' => '5',
                    'number_of_seats' => '4',
                    'length' => '3,98 m',
                    'trunk_volume' => 'Moyen Coffre',
                    'related_car' => '',
                ],
                'equipmentOptions' => [
                    'exterior_and_chassis' => [
                        'Rétroviseurs extérieurs réglage électrique','Phares à allumage automatique','Ampoules de phares bi-xénon','Freins régénérateurs','Feux arrières à LED','4 roues motrices','Aide parking av/ar','Becquet','Jantes alu 18','Rétroviseurs électriques et dégivrants','Rétroviseurs rabattables électriquement',
                    ],
                    'interior' => [
                        'Reconnaissance vocale','8 haut-parleurs','Régulateur de vitesse','Air conditionné 1 zones','Réglage du volant en hauteur, en profondeur','Taille écran multi-fonctions 6.5 pouces','Climatisation automatique','Démarrage sans clef','Régulateur limiteur de vitesse','Rétroviseur int. jour/nuit auto','Vitres ar. surteintées',
                        'Volant cuir','Ordinateur de bord','Système audio carte digitale', 'CD','Air conditionné auto','Tapis de sol','Système de navigation','Taille écran navigation 6.5 pouces','Accoudoir central avant','Système audio lecteur CD et MP3','Système de navigation info trafic','Rétroviseur jour/nuit','Volant multi-fonction','Bluetooth inclut musique en streaming, connexion téléphone','Bluetooth',
                    ],
                    'security' => [
                    '6 airbags','ESP','Airbags rideaux','Antipatinage','Lave-phares','Indicateur de sous-gonflage des pneus','Assistance au freinage d\'urgence','ABS','Airbags latéraux','Kit anticrevaison','Essuie glace capteur de pluie','Feux ar. à LED','Feux automatiques',
                    ],
                    'security_lock' => 'Boulons antivol de roues',
                    'related_car' => '',
                ]


            ],
            'PORSCHE_CAYENNE' => [
                'name' => 'PORSCHE CAYENNE III COUPE 3.0 V6 340',
                'images' => ['porshe1.jpg', 'porshe2.jpg', 'porshe3.jpg', 'porshe4.jpg', 'porshe5.jpg'],
                'price' => '94 990',
                'fiscal_power' => '23 CV',
                'engine_power' => '(DIN) 340 ch - (moteur) 250 kW',
                'euro_standard' => 'EURO6',
                'crit_air' => '1',
                'combined_consumption' => '9 L/100 km',
                'co2_emission' => 'F',
                'posted_at' => date('now'),
                'poster' => $admin,
                'model' => ''/**Trouver le modèle correspondant */,
                'characteristics' => [
                    'year_of_launch' => '04-07-2019',
                    'origin' => 'France',
                    'technichal_control' => 'Requis',
                    'first_hand' => 'Oui',
                    'energy' => 'Essence',
                    'gearbox' => 'Automatique',
                    'color' => 'orange metalSellerie',
                    'number_of_doors' => '5',
                    'number_of_seats' => '5',
                    'length' => '4,93 m',
                    'trunk_volume' => 'Grand coffre',
                    'related_car' => '',
                ],
                'equipmentOptions' => [
                    'exterior_and_chassis' => [
                    'Phares à allumage automatique','Ampoules de phares LED','Freins régénérateurs','Feux arrières à LED','Rétroviseurs extérieurs réglage électrique','Feux de route à LED','Rétroviseurs extérieurs chauffants','Rétroviseurs rabattables électriquement','Aide parking avec caméra de recul','Becquet','Hayon électrique','Jantes alu 21"','Rétroviseurs électriques et dégivrants','Rétroviseurs rabattables','Toit panoramique',
                    ],
                    'interior' => [
                'Système audio écran tactile, carte digitale, CD','Bouton démarrage','Palettes au volant','Fermerture électrique du coffre','Air conditionné auto','Système de navigation','Système audio lecteur CD et MP3','Connexion Internet','Bluetooth inclut musique en streaming, connexion téléphone','DVD/VCD','Régulateur de vitesse','Smart card / Smart key','Volant alu & cuir','Système audio inclut DVD','Ordinateur de bord','Siège avant électrique','Ouverture du coffre à distance','Taille écran navigation 12 pouces','Accoudoir central avant','Système de navigation info trafic','Limiteur de vitesse','Volant multi-fonction','Réseau Wifi','Bluetooth','Reconnaissance vocale','10 haut-parleurs','Air conditionné 2 zones','Pré-équipement téléphone','Réglage du volant en hauteur, en profondeur','Taille écran multi-fonctions 12 pouces','Boite automatique','Régulateur limiteur de vitesse','Volant et pommeau cuir','Volant multifonctions','APPLE CAR PLAY',
                    ],
                    'security' => [
                '8 airbags','ESP','Airbags rideaux','Système détection de collision','Indicateur de sous-gonflage des pneus','Assistance au freinage d\'urgence','Kit anticrevaison','Essuie glace capteur de pluie','Capot à soulèvement pour choc piéton','Antipatinage','ABS','Airbags latéraux','Aide au démarrage en côte','Feux et essuie-glaces automatiques','Phares av. de jour à LED',
                    ],
                    'security_lock' => 'Alarme',
                    'related_car' => '',
                ]


            ],
            'NISSAN_QASHQAI' => [
                'name' => 'NISSAN QASHQAI II 1.2 DIG-T 115 N-CONNECTA',
                'images' => ['nissan2.jpg', 'nissan3.jpg', 'nissan4.jpg', 'nissan1.jpg', 'nissan5.jpg'],
                'price' => '14 490',
                'fiscal_power' => '6 CV',
                'engine_power' => '(DIN) 116 ch - (moteur) 85 kW',
                'euro_standard' => 'EURO6',
                'crit_air' => '1',
                'combined_consumption' => '5,2 L/100 km',
                'co2_emission' => 'C',
                'posted_at' => date('now'),
                'poster' => $admin,
                'model' => ''/**Trouver le modèle correspondant */,
                'characteristics' => [
                    'year_of_launch' => '29-04-2016',
                    'origin' => 'France',
                    'technichal_control' => 'Requis',
                    'first_hand' => 'Non',
                    'energy' => 'Essence',
                    'gearbox' => 'Manuelle',
                    'color' => 'noir metalSellerie',
                    'number_of_doors' => '5',
                    'number_of_seats' => '5',
                    'length' => '4,38 m',
                    'trunk_volume' => 'Moyen Coffre',
                    'related_car' => '',
                ],
                'equipmentOptions' => [
                    'exterior_and_chassis' => [
                'Extérieur et Chassis','Différentiel à glissement limité avant','Rétroviseurs extérieurs réglage électrique','Phares à allumage automatique','Rétroviseurs extérieurs chauffants','Ampoules de phares halogènes','Feux arrières à LED','Feux de croisement automatiques','Caméra d\'aide au stationnement à 360°','Rétroviseurs rabattables électriquement','Antibrouillards avant','Aide parking avec caméra de recul','Barres de toit','Jantes alu 18"',
                    ],
                    'interior' => [
                'Volant alu & cuir','Système audio écran tactile, CD','Bouton démarrage','Aide au stationnement arrière','Ordinateur de bord','Air conditionné auto','Ouverture du coffre à distance','Système de navigation','Taille écran navigation 7 pouces','Accoudoir central arrière, avant','Système audio lecteur CD et MP3','Système de navigation info trafic','Limiteur de vitesse','Rétroviseur jour/nuit','Volant multi-fonction','Bluetooth inclut musique en streaming, connexion téléphone','Bluetooth','6 haut-parleurs','Régulateur de vitesse','Air conditionné 2 zones','Réglage du volant en hauteur, en profondeur','Smart card / Smart key','Taille écran multi-fonctions 7 pouces','Climatisation automatique',
                    ],
                    'security' => [
                '6 airbags','ESP','Airbags rideaux','Contrôle de freinage en courbe','Détection panneaux signalisation','Antipatinage','Système détection de collision','Indicateur de sous-gonflage des pneus','Assistance au freinage d\'urgence','ABS','Avertisseur de franchissement de ligne','Airbags latéraux','Kit anticrevaison','Essuie glace capteur de pluie','Aide au démarrage en côte','Essuie-glaces automatiques',
                    ],
                    'security_lock' => '',
                    'related_car' => '',
                ]


            ],
            'AUDI_Q3' => [
                'name' => 'AUDI Q3 (2) 2.0 TDI 150 S LINE QUATTRO S TRONIC',
                'images' => ['audiq3_1.jpg', 'audiq3_2.jpg', 'audiq3_3.jpg', 'audiq3_4.jpg', 'audiq3_5.jpg'],
                'price' => '21 000',
                'fiscal_power' => '8 CV',
                'engine_power' => '(DIN) 150 ch - (moteur) 110 kW',
                'euro_standard' => 'EURO6',
                'crit_air' => '2',
                'combined_consumption' => '4,6 L/100 km',
                'co2_emission' => 'c',
                'posted_at' => date('now'),
                'poster' => $admin,
                'model' => ''/**Trouver le modèle correspondant */,
                'characteristics' => [
                    'year_of_launch' => '29-02-2016',
                    'origin' => 'France',
                    'technichal_control' => 'Requis',
                    'first_hand' => 'Non',
                    'energy' => 'Diesel',
                    'gearbox' => 'Automatique',
                    'color' => 'noir metalSellerie',
                    'number_of_doors' => '5',
                    'number_of_seats' => '5',
                    'length' => '4,39 m',
                    'trunk_volume' => 'Moyen Coffre',
                    'related_car' => '',
                ],
                'equipmentOptions' => [
                    'exterior_and_chassis' => [
                'Extérieur et Chassis','Rétroviseurs extérieurs réglage électrique','Roue de secours','Phares à allumage automatique','Rétroviseurs extérieurs chauffants','Ampoules de phares bi-xénon','Freins régénérateurs','Feux arrières à LED','Rétroviseurs rabattables électriquement','Aide parking av/ar','Barres de toit','Becquet','Jantes alu 18"','Rétroviseurs électriques et dégivrants','Rétroviseurs rabattables','Toit ouvrant panoramique',
                    ],
                    'interior' => [
                'Volant cuir','Système audio carte digitale, CD','Palettes au volant','Ordinateur de bord','Siège avant électrique','Air conditionné auto','Tapis de sol','Ouverture du coffre à distance','Système de navigation','Taille écran navigation 6.5 pouces','Accoudoir central avant','Système audio lecteur CD et MP3','Rétroviseur jour/nuit','Volant multi-fonction','Bluetooth inclut musique en streaming, connexion téléphone','Bluetooth','10 haut-parleurs','Régulateur de vitesse','Air conditionné 2 zones','Réglage du volant en hauteur, en profondeur','Taille écran multi-fonctions 6.5 pouces','Banquette rabattable',
                    ],
                    'security' => [
                '6 airbags','ESP','Airbags rideaux','Antipatinage','Système détection de collision','Indicateur de sous-gonflage des pneus','Assistance au freinage d\'urgence','ABS','Airbags latéraux','Essuie glace capteur de pluie','Contrôle de pression des pneus','Essuie-glaces automatiques','Feux automatiques','Fixations ISOFIX',
                    ],
                    'security_lock' => '',
                    'related_car' => '',
                ]


            ]
                
        ];
        foreach($cars as $car_name => $car_attributes){
            $car = new Car();
            $car->setName($car_attributes['name']);
            $car->setImages($car_attributes['images']);
            $car->setPrice((int)$car_attributes['price']);
            $car->setFiscalPower($car_attributes['fiscal_power']);
            $car->setEnginePower($car_attributes['engine_power']);
            $car->setEuroStandard($car_attributes['euro_standard']);
            $car->setCritAir($car_attributes['crit_air']);
            $car->setCombinedConsumption($car_attributes['combined_consumption']);
            $car->setCo2Emission($car_attributes['co2_emission']);
            $car->setPostedAt(new DateTime());

            $characteristic = $this->createCharacteristics($car_attributes['characteristics']);
            $characteristic->setRelatedCar($car);
            $manager->persist($characteristic);
            
            $equipments = $this->createEquipments($car_attributes['equipmentOptions']);
            $equipments->setRelatedCar($car);
            $manager->persist($equipments);

            $car->setCharacteristics($characteristic);
            $car->setEquipmentOptions($equipments);
            $car->setPoster($admin);
            
            /**Liaison des voitures à leurs différents modèles */
            switch ($car_name) {
                case 'FIAT_500':
                    $car->setModel($this->getReference(self::FIAT_500_REFERENCE));
                    break;
                case 'NISSAN_QASHQAI':
                    $car->setModel($this->getReference(self::NISSAN_QUASQUAI_REFERENCE));
                    break;
                case 'VOLKSWAGEN_TROC':
                    $car->setModel($this->getReference(self::VOLKSWAGEN_TROC_REFERENCE));
                    break;
                case 'AUDI_S1':
                        $car->setModel($this->getReference(self::AUDI_S1_REFERENCE));
                        break;
                case 'PORSCHE_CAYENNE':
                    $car->setModel($this->getReference(self::PORSCHE_CAYENNE_REFERENCE));
                    break;            
                case 'AUDI_Q3':
                    $car->setModel($this->getReference(self::AUDI_Q3_REFERENCE));
                    break;
            }

            $manager->persist($car);

        }

        /** Créer des services toujours raccordés à cet utilisateur comme publisher */
        $services = [
            [
                'image' => 'carosserie.jpg',
                'title' => 'Mécanique générale toute marque',
                'description' => "Un travail de qualité, qui est notre priorité, sera effectué sur votre véhicule, c’est pourquoi nous travaillons avec le meilleur outillage possible, et uniquement avec de la pièce neuve d’origine.
                                Nous intervenons sur tous types de travaux, sur de l’entretien classique aussi bien que sur de la mécanique lourde, comme remplacement ou réfection d’un moteur.
                                Dans notre établissement, aucune intervention ne sera effectuée sur votre véhicule sans votre accord.
                                Donc pas de mauvaises surprises au moment de la facture.
                                Pour les sociétés, ainsi que les comités d’entreprises qui nous confient l’entretien de leur flotte de véhicule, nous mettons en place automatiquement un taux de remise, ainsi qu’un service très réactif au niveau des délais, ainsi que sur les véhicules de courtoisie.",
                'poster' => $admin,
            ],                                
            [
                'image' => 'carosserie.jpg',
                'title' => 'Entretien et remise à zéro des compteurs',
                'description' => "Le Garage effectue vos révisions périodiques et vidanges avec remise à zéro des témoins d’entretien, sur tous types de véhicules, même les plus récents.
                                Nos entretiens suivent le programme constructeur et conservent ainsi la garantie du véhicule.
                                Le Libre choix du garagiste : les réglementations européennes et françaises vous autorisent à faire entretenir votre véhicule (hors intervention prise en charge dans le cadre d’une garantie) par, le professionnel de votre choix sans perdre la garantie légale de 2 ans à la vente d’un véhicule neuf.",
                'poster' => $admin,
            ],                                
            [
                'image' => 'carosserie.jpg',
                'title' => 'Diagnostique et recherche de panne électrique, électronique',
                'description' => "Le garage est équipé de matériel diagnostic haut de gamme mis à jour afin de pouvoir interroger vos calculateurs et ainsi faire le meilleur diagnostic possible sur votre véhicule.
                                 Nous sommes équipés de plusieurs ordinateurs de diagnostic pour couvrir la totalité du parc auto, et ainsi intervenir sur toutes les marques possibles.",
                'poster' => $admin,
            ],                                 
            [
                'image' => 'carosserie.jpg',
                'title' => 'Réparation de la carosserie',
                'description' => "Votre carrosserie représente l’aspect extérieur de votre véhicule. Sa protection est donc essentielle pour l’entretien et l’apparence de votre véhicule personnelle. Et si elle est malgré tout abîmée, il faut alors trouver un garage qui fasse la réparation de carrosserie pour que votre voiture retrouve sa valeur esthétique et monétaire, un garage comme V.Parrot.",
                'poster' => $admin,
            ],                
        ];
        foreach($services as $serviceTemplate){
            $service = new Service();
            $service->setImage($serviceTemplate['image']);
            $service->setDescription($serviceTemplate['description']);
            $service->setTitle($serviceTemplate['title']);
            $service->setPoster($admin);
            $manager->persist($service);
        }
        // $product = new Product();
        // $manager->persist($product);

    $manager->flush();
    }
    private function createCharacteristics($characteristics) : CarCaracteristic{
        $characteristic = new CarCaracteristic();
        $characteristic->setYearOfLaunch(new DateTime(date($characteristics['year_of_launch'])));
        $characteristic->setOrigin($characteristics['origin']);
        $characteristic->setTechnichalControl($characteristics['technichal_control']);
        $characteristic->setFirstHand($characteristics['first_hand']);
        $characteristic->setEnergy($characteristics['energy']);
        $characteristic->setGearbox($characteristics['gearbox']);
        $characteristic->setColor($characteristics['color']);
        $characteristic->setNumberOfDoors($characteristics['number_of_doors']);
        $characteristic->setNumberOfSeats($characteristics['number_of_seats']);
        $characteristic->setLength((int)$characteristics['length']);
        $characteristic->setTrunkVolume($characteristics['trunk_volume']);
        return $characteristic;
    }

    private function createEquipments(array $equipments_options): EquipmentOptions
    {
        $equipments = new EquipmentOptions();
        $equipments->setExteriorAndChassis($equipments_options['exterior_and_chassis']);
        $equipments->setInterior($equipments_options['interior']);
        $equipments->setSecurity($equipments_options['security']);
        $equipments->setSecurityLock($equipments_options['security_lock']);
        return $equipments;
    }
}
