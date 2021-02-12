<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Helper;

use LinkyApp\Controllers\indexController;
use LinkyApp\Entity\Link;
use LinkyApp\Entity\Socials;

/**
 * Class WPLinkyHelper
 * @since 1.0.0
 */
abstract class WPLinkyHelper
{
    const WP_LINKY_OPTION_PAGE_KEY  = 'page';
    const GOOGLE_FONTS              = '["ABeeZee","Abel","Abhaya Libre","Abril Fatface","Aclonica","Acme","Actor","Adamina","Advent Pro","Aguafina Script","Akronim","Aladin","Alata","Alatsi","Aldrich","Alef","Alegreya","Alegreya SC","Alegreya Sans","Alegreya Sans SC","Aleo","Alex Brush","Alfa Slab One","Alice","Alike","Alike Angular","Allan","Allerta","Allerta Stencil","Allura","Almarai","Almendra","Almendra Display","Almendra SC","Amarante","Amaranth","Amatic SC","Amethysta","Amiko","Amiri","Amita","Anaheim","Andada","Andika","Andika New Basic","Angkor","Annie Use Your Telescope","Anonymous Pro","Antic","Antic Didone","Antic Slab","Anton","Arapey","Arbutus","Arbutus Slab","Architects Daughter","Archivo","Archivo Black","Archivo Narrow","Aref Ruqaa","Arima Madurai","Arimo","Arizonia","Armata","Arsenal","Artifika","Arvo","Arya","Asap","Asap Condensed","Asar","Asset","Assistant","Astloch","Asul","Athiti","Atma","Atomic Age","Aubrey","Audiowide","Autour One","Average","Average Sans","Averia Gruesa Libre","Averia Libre","Averia Sans Libre","Averia Serif Libre","B612","B612 Mono","Bad Script","Bahiana","Bahianita","Bai Jamjuree","Ballet","Baloo 2","Baloo Bhai 2","Baloo Bhaina 2","Baloo Chettan 2","Baloo Da 2","Baloo Paaji 2","Baloo Tamma 2","Baloo Tammudu 2","Baloo Thambi 2","Balsamiq Sans","Balthazar","Bangers","Barlow","Barlow Condensed","Barlow Semi Condensed","Barriecito","Barrio","Basic","Baskervville","Battambang","Baumans","Bayon","Be Vietnam","Bebas Neue","Belgrano","Bellefair","Belleza","Bellota","Bellota Text","BenchNine","Benne","Bentham","Berkshire Swash","Beth Ellen","Bevan","Big Shoulders Display","Big Shoulders Inline Display","Big Shoulders Inline Text","Big Shoulders Stencil Display","Big Shoulders Stencil Text","Big Shoulders Text","Bigelow Rules","Bigshot One","Bilbo","Bilbo Swash Caps","BioRhyme","BioRhyme Expanded","Biryani","Bitter","Black And White Picture","Black Han Sans","Black Ops One","Blinker","Bodoni Moda","Bokor","Bonbon","Boogaloo","Bowlby One","Bowlby One SC","Brawler","Bree Serif","Brygada 1918","Bubblegum Sans","Bubbler One","Buda","Buenard","Bungee","Bungee Hairline","Bungee Inline","Bungee Outline","Bungee Shade","Butcherman","Butterfly Kids","Cabin","Cabin Condensed","Cabin Sketch","Caesar Dressing","Cagliostro","Cairo","Caladea","Calistoga","Calligraffitti","Cambay","Cambo","Candal","Cantarell","Cantata One","Cantora One","Capriola","Cardo","Carme","Carrois Gothic","Carrois Gothic SC","Carter One","Castoro","Catamaran","Caudex","Caveat","Caveat Brush","Cedarville Cursive","Ceviche One","Chakra Petch","Changa","Changa One","Chango","Charm","Charmonman","Chathura","Chau Philomene One","Chela One","Chelsea Market","Chenla","Cherry Cream Soda","Cherry Swash","Chewy","Chicle","Chilanka","Chivo","Chonburi","Cinzel","Cinzel Decorative","Clicker Script","Coda","Coda Caption","Codystar","Coiny","Combo","Comfortaa","Comic Neue","Coming Soon","Commissioner","Concert One","Condiment","Content","Contrail One","Convergence","Cookie","Copse","Corben","Cormorant","Cormorant Garamond","Cormorant Infant","Cormorant SC","Cormorant Unicase","Cormorant Upright","Courgette","Courier Prime","Cousine","Coustard","Covered By Your Grace","Crafty Girls","Creepster","Crete Round","Crimson Pro","Crimson Text","Croissant One","Crushed","Cuprum","Cute Font","Cutive","Cutive Mono","DM Mono","DM Sans","DM Serif Display","DM Serif Text","Damion","Dancing Script","Dangrek","Darker Grotesque","David Libre","Dawning of a New Day","Days One","Dekko","Delius","Delius Swash Caps","Delius Unicase","Della Respira","Denk One","Devonshire","Dhurjati","Didact Gothic","Diplomata","Diplomata SC","Do Hyeon","Dokdo","Domine","Donegal One","Doppio One","Dorsa","Dosis","Dr Sugiyama","Duru Sans","Dynalight","EB Garamond","Eagle Lake","East Sea Dokdo","Eater","Economica","Eczar","El Messiri","Electrolize","Elsie","Elsie Swash Caps","Emblema One","Emilys Candy","Encode Sans","Encode Sans Condensed","Encode Sans Expanded","Encode Sans Semi Condensed","Encode Sans Semi Expanded","Engagement","Englebert","Enriqueta","Epilogue","Erica One","Esteban","Euphoria Script","Ewert","Exo","Exo 2","Expletus Sans","Fahkwang","Fanwood Text","Farro","Farsan","Fascinate","Fascinate Inline","Faster One","Fasthand","Fauna One","Faustina","Federant","Federo","Felipa","Fenix","Finger Paint","Fira Code","Fira Mono","Fira Sans","Fira Sans Condensed","Fira Sans Extra Condensed","Fjalla One","Fjord One","Flamenco","Flavors","Fondamento","Fontdiner Swanky","Forum","Francois One","Frank Ruhl Libre","Fraunces","Freckle Face","Fredericka the Great","Fredoka One","Freehand","Fresca","Frijole","Fruktur","Fugaz One","GFS Didot","GFS Neohellenic","Gabriela","Gaegu","Gafata","Galada","Galdeano","Galindo","Gamja Flower","Gayathri","Gelasio","Gentium Basic","Gentium Book Basic","Geo","Geostar","Geostar Fill","Germania One","Gidugu","Gilda Display","Girassol","Give You Glory","Glass Antiqua","Glegoo","Gloria Hallelujah","Goblin One","Gochi Hand","Goldman","Gorditas","Gothic A1","Gotu","Goudy Bookletter 1911","Graduate","Grand Hotel","Grandstander","Gravitas One","Great Vibes","Grenze","Grenze Gotisch","Griffy","Gruppo","Gudea","Gugi","Gupter","Gurajada","Habibi","Hachi Maru Pop","Halant","Hammersmith One","Hanalei","Hanalei Fill","Handlee","Hanuman","Happy Monkey","Harmattan","Headland One","Heebo","Henny Penny","Hepta Slab","Herr Von Muellerhoff","Hi Melody","Hind","Hind Guntur","Hind Madurai","Hind Siliguri","Hind Vadodara","Holtwood One SC","Homemade Apple","Homenaje","IBM Plex Mono","IBM Plex Sans","IBM Plex Sans Condensed","IBM Plex Serif","IM Fell DW Pica","IM Fell DW Pica SC","IM Fell Double Pica","IM Fell Double Pica SC","IM Fell English","IM Fell English SC","IM Fell French Canon","IM Fell French Canon SC","IM Fell Great Primer","IM Fell Great Primer SC","Ibarra Real Nova","Iceberg","Iceland","Imbue","Imprima","Inconsolata","Inder","Indie Flower","Inika","Inknut Antiqua","Inria Sans","Inria Serif","Inter","Irish Grover","Istok Web","Italiana","Italianno","Itim","Jacques Francois","Jacques Francois Shadow","Jaldi","JetBrains Mono","Jim Nightshade","Jockey One","Jolly Lodger","Jomhuria","Jomolhari","Josefin Sans","Josefin Slab","Jost","Joti One","Jua","Judson","Julee","Julius Sans One","Junge","Jura","Just Another Hand","Just Me Again Down Here","K2D","Kadwa","Kalam","Kameron","Kanit","Kantumruy","Karla","Karma","Katibeh","Kaushan Script","Kavivanar","Kavoon","Kdam Thmor","Keania One","Kelly Slab","Kenia","Khand","Khmer","Khula","Kirang Haerang","Kite One","Knewave","KoHo","Kodchasan","Kosugi","Kosugi Maru","Kotta One","Koulen","Kranky","Kreon","Kristi","Krona One","Krub","Kufam","Kulim Park","Kumar One","Kumar One Outline","Kumbh Sans","Kurale","La Belle Aurore","Lacquer","Laila","Lakki Reddy","Lalezar","Lancelot","Langar","Lateef","Lato","League Script","Leckerli One","Ledger","Lekton","Lemon","Lemonada","Lexend Deca","Lexend Exa","Lexend Giga","Lexend Mega","Lexend Peta","Lexend Tera","Lexend Zetta","Libre Barcode 128","Libre Barcode 128 Text","Libre Barcode 39","Libre Barcode 39 Extended","Libre Barcode 39 Extended Text","Libre Barcode 39 Text","Libre Barcode EAN13 Text","Libre Baskerville","Libre Caslon Display","Libre Caslon Text","Libre Franklin","Life Savers","Lilita One","Lily Script One","Limelight","Linden Hill","Literata","Liu Jian Mao Cao","Livvic","Lobster","Lobster Two","Londrina Outline","Londrina Shadow","Londrina Sketch","Londrina Solid","Long Cang","Lora","Love Ya Like A Sister","Loved by the King","Lovers Quarrel","Luckiest Guy","Lusitana","Lustria","M PLUS 1p","M PLUS Rounded 1c","Ma Shan Zheng","Macondo","Macondo Swash Caps","Mada","Magra","Maiden Orange","Maitree","Major Mono Display","Mako","Mali","Mallanna","Mandali","Manjari","Manrope","Mansalva","Manuale","Marcellus","Marcellus SC","Marck Script","Margarine","Markazi Text","Marko One","Marmelad","Martel","Martel Sans","Marvel","Mate","Mate SC","Maven Pro","McLaren","Meddon","MedievalSharp","Medula One","Meera Inimai","Megrim","Meie Script","Merienda","Merienda One","Merriweather","Merriweather Sans","Metal","Metal Mania","Metamorphous","Metrophobic","Michroma","Milonga","Miltonian","Miltonian Tattoo","Mina","Miniver","Miriam Libre","Mirza","Miss Fajardose","Mitr","Modak","Modern Antiqua","Mogra","Molengo","Molle","Monda","Monofett","Monoton","Monsieur La Doulaise","Montaga","Montez","Montserrat","Montserrat Alternates","Montserrat Subrayada","Moul","Moulpali","Mountains of Christmas","Mouse Memoirs","Mr Bedfort","Mr Dafoe","Mr De Haviland","Mrs Saint Delafield","Mrs Sheppards","Mukta","Mukta Mahee","Mukta Malar","Mukta Vaani","Mulish","MuseoModerno","Mystery Quest","NTR","Nanum Brush Script","Nanum Gothic","Nanum Gothic Coding","Nanum Myeongjo","Nanum Pen Script","Nerko One","Neucha","Neuton","New Rocker","News Cycle","Newsreader","Niconne","Niramit","Nixie One","Nobile","Nokora","Norican","Nosifer","Notable","Nothing You Could Do","Noticia Text","Noto Sans","Noto Sans HK","Noto Sans JP","Noto Sans KR","Noto Sans SC","Noto Sans TC","Noto Serif","Noto Serif JP","Noto Serif KR","Noto Serif SC","Noto Serif TC","Nova Cut","Nova Flat","Nova Mono","Nova Oval","Nova Round","Nova Script","Nova Slim","Nova Square","Numans","Nunito","Nunito Sans","Odibee Sans","Odor Mean Chey","Offside","Old Standard TT","Oldenburg","Oleo Script","Oleo Script Swash Caps","Open Sans","Open Sans Condensed","Oranienbaum","Orbitron","Oregano","Orienta","Original Surfer","Oswald","Over the Rainbow","Overlock","Overlock SC","Overpass","Overpass Mono","Ovo","Oxanium","Oxygen","Oxygen Mono","PT Mono","PT Sans","PT Sans Caption","PT Sans Narrow","PT Serif","PT Serif Caption","Pacifico","Padauk","Palanquin","Palanquin Dark","Pangolin","Paprika","Parisienne","Passero One","Passion One","Pathway Gothic One","Patrick Hand","Patrick Hand SC","Pattaya","Patua One","Pavanam","Paytone One","Peddana","Peralta","Permanent Marker","Petit Formal Script","Petrona","Philosopher","Piazzolla","Piedra","Pinyon Script","Pirata One","Plaster","Play","Playball","Playfair Display","Playfair Display SC","Podkova","Poiret One","Poller One","Poly","Pompiere","Pontano Sans","Poor Story","Poppins","Port Lligat Sans","Port Lligat Slab","Potta One","Pragati Narrow","Prata","Preahvihear","Press Start 2P","Pridi","Princess Sofia","Prociono","Prompt","Prosto One","Proza Libre","Public Sans","Puritan","Purple Purse","Quando","Quantico","Quattrocento","Quattrocento Sans","Questrial","Quicksand","Quintessential","Qwigley","Racing Sans One","Radley","Rajdhani","Rakkas","Raleway","Raleway Dots","Ramabhadra","Ramaraja","Rambla","Rammetto One","Ranchers","Rancho","Ranga","Rasa","Rationale","Ravi Prakash","Recursive","Red Hat Display","Red Hat Text","Red Rose","Redressed","Reem Kufi","Reenie Beanie","Reggae One","Revalia","Rhodium Libre","Ribeye","Ribeye Marrow","Righteous","Risque","Roboto","Roboto Condensed","Roboto Mono","Roboto Slab","Rochester","Rock Salt","Rokkitt","Romanesco","Ropa Sans","Rosario","Rosarivo","Rouge Script","Rowdies","Rozha One","Rubik","Rubik Mono One","Ruda","Rufina","Ruge Boogie","Ruluko","Rum Raisin","Ruslan Display","Russo One","Ruthie","Rye","Sacramento","Sahitya","Sail","Saira","Saira Condensed","Saira Extra Condensed","Saira Semi Condensed","Saira Stencil One","Salsa","Sanchez","Sancreek","Sansita","Sansita Swashed","Sarabun","Sarala","Sarina","Sarpanch","Satisfy","Sawarabi Gothic","Sawarabi Mincho","Scada","Scheherazade","Schoolbell","Scope One","Seaweed Script","Secular One","Sedgwick Ave","Sedgwick Ave Display","Sen","Sevillana","Seymour One","Shadows Into Light","Shadows Into Light Two","Shanti","Share","Share Tech","Share Tech Mono","Shojumaru","Short Stack","Shrikhand","Siemreap","Sigmar One","Signika","Signika Negative","Simonetta","Single Day","Sintony","Sirin Stencil","Six Caps","Skranji","Slabo 13px","Slabo 27px","Slackey","Smokum","Smythe","Sniglet","Snippet","Snowburst One","Sofadi One","Sofia","Solway","Song Myung","Sonsie One","Sora","Sorts Mill Goudy","Source Code Pro","Source Sans Pro","Source Serif Pro","Space Grotesk","Space Mono","Spartan","Special Elite","Spectral","Spectral SC","Spicy Rice","Spinnaker","Spirax","Squada One","Sree Krushnadevaraya","Sriracha","Srisakdi","Staatliches","Stalemate","Stalinist One","Stardos Stencil","Stint Ultra Condensed","Stint Ultra Expanded","Stoke","Strait","Stylish","Sue Ellen Francisco","Suez One","Sulphur Point","Sumana","Sunflower","Sunshiney","Supermercado One","Sura","Suranna","Suravaram","Suwannaphum","Swanky and Moo Moo","Syncopate","Syne","Syne Mono","Syne Tactile","Tajawal","Tangerine","Taprom","Tauri","Taviraj","Teko","Telex","Tenali Ramakrishna","Tenor Sans","Text Me One","Texturina","Thasadith","The Girl Next Door","Tienne","Tillana","Timmana","Tinos","Titan One","Titillium Web","Tomorrow","Trade Winds","Trirong","Trispace","Trocchi","Trochut","Truculenta","Trykker","Tulpen One","Turret Road","Ubuntu","Ubuntu Condensed","Ubuntu Mono","Ultra","Uncial Antiqua","Underdog","Unica One","UnifrakturCook","UnifrakturMaguntia","Unkempt","Unlock","Unna","VT323","Vampiro One","Varela","Varela Round","Varta","Vast Shadow","Vesper Libre","Viaoda Libre","Vibes","Vibur","Vidaloka","Viga","Voces","Volkhov","Vollkorn","Vollkorn SC","Voltaire","Waiting for the Sunrise","Wallpoet","Walter Turncoat","Warnes","Wellfleet","Wendy One","Wire One","Work Sans","Xanh Mono","Yanone Kaffeesatz","Yantramanav","Yatra One","Yellowtail","Yeon Sung","Yeseva One","Yesteryear","Yrsa","Yusei Magic","ZCOOL KuaiLe","ZCOOL QingKe HuangYou","ZCOOL XiaoWei","Zeyada","Zhi Mang Xing","Zilla Slab","Zilla Slab Highlight"]';

    /**
     * Get index cotroller class
     *
     * @return \LinkyApp\Controllers\IndexController
     */
    public static function getIndexController($page_id = false)
    {
        $indexController = new IndexController($page_id);

        return $indexController;
    }

    /**
     * Get page option key
     *
     * @return string
     */
    public static function getPageOptionKey($page_id = false)
    {
        return 'wp_linky_' . self::WP_LINKY_OPTION_PAGE_KEY . (!empty($page_id) ? '_' . $page_id : '');
    }

    /**
     * Get all pages options
     *
     * @return array
     */
    public static function getPageOption($page_id = false)
    {
        $options = get_option(self::getPageOptionKey($page_id));
        return !empty($options) ? $options : [];
    }

    /**
     * Get random identifier (sanitized)
     *
     * @return string
     */
    public static function getRandomIdentifier()
    {
        return sanitize_title(wp_generate_uuid4());
    }

    /**
     * Get default labels
     *
     * @return string
     */
    public static function getDefaultLabels()
    {
        $link = new Link();
        return implode(',', $link->get('defaultLabels'));
    }

    /**
     * Get default categories
     *
     * @return string
     */
    public static function getDefaultCategories()
    {
        $link = new Link();
        return implode(',', $link->get('defaultCategories'));
    }

    /**
     * Get option value from option key, and return default value if value is empty
     *
     * @param string $key option key
     * @param array $data options array
     * @param mixed $default default value return
     * @param string $callback callback function name
     *
     * @return mixed
     */
    public static function getOptionValue($key, $data, $default = null, $callback = false)
    {
        $value = !empty($data[$key]) ? $data[$key] : $default;
        if((bool) $callback) {
            if(is_array($callback)) {
                return ($callback[0] == self::class) ? $callback[0]::{$callback[1]}($value) : $callback[0]->{$callback[1]}($value);
            } else {
                return call_user_func($callback, $value);
            }
        } else {
            return $value;
        }
    }

    /**
     * Get social keys
     *
     * @return array
     */
    public static function getSocials()
    {
        return array_keys(get_class_vars(Socials::class));
    }

    /**
     * Return view path form partial name
     *
     * @param string $partial partial name
     *
     * @return string
     */
    public static function getViewPath($partial = null)
    {
        return UNDFND_WP_LINKY_PLUGIN_DIR . 'views/' . ($partial ? $partial . '.php' : '');
    }

    /**
     * Get Options Page
     *
     * @param string|bool $group group needed
     *
     * @return string|array
     */
    public static function getPage($group = false, $page_id = false)
    {
        $options = self::getPageOption($page_id);
        foreach(['global', 'appareance', 'social', 'links', 'themes', 'page_name'] as $item) {
            if(!array_key_exists($item, $options))
                $options[$item] = [];
        }

        return !empty($group) ? self::getOptionValue($group, $options) : $options;
    }

    /**
     * Get Links Pages
     *
     * @return array
     */
    public static function getPages()
    {
        global $wpdb;
        $pages = [];
        $pagesQ = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE 'wp_linky_page%'");
        if(!empty($pagesQ)) {
            foreach($pagesQ as $page) {
                $key = ($page->option_name == self::getPageOptionKey()) ? 0 : str_replace(self::getPageOptionKey() . '_', '', $page->option_name);
                $options = unserialize($page->option_value);
                $pages[$key] = !empty($options['page_name']) ? $options['page_name'] : __( 'Default page', 'linky' );
            }
        }

        return $pages;
    }

    /**
     * Unescape string
     *
     * @param string $field string
     * @param bool $escape
     *
     * @return string
     */
    public static function unEscape($field, $escape = true)
    {
        if(is_string($field) && $escape):
            $field = stripslashes($field);
            $field = str_replace('"', '&quot;', $field);
        endif;

        return $field;
    }

    /**
     * Filter code string
     *
     * @param string $code string code
     *
     * @return string
     */
    public static function codeFilter($code)
    {
        $code = str_replace("\'", "'", $code);
        $code = str_replace('\"', '"', $code);
        return $code;
    }

    /**
     * Include files from dir path
     *
     * @param string $dirPath dir path
     * @param array $exclude exclude files
     *
     * @return void
     */
    public static function includesFiles($dirPath, $exclude = [])
    {
        if(is_dir($dirPath)) {
            $files = scandir($dirPath);
            foreach($files as $file){
                if(!in_array($file, $exclude) && preg_match('#.php$#i', $file)){
                    include_once( $dirPath . '/' . $file );
                }
            }
        }
    }

    /**
     * Recursive sanitation for an array
     *
     * @param array $array
     *
     * @return mixed
     */
    public static function recursiveSanitizeTextField($array) {
        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = self::recursiveSanitizeTextField($value);
            }
            else if($key !== 'code_ga') {
                $value = sanitize_text_field( $value );
            }
        }

        return $array;
    }


    /**
     * Set Default Page content
     *
     * @param bool $page_id
     */
    public static function setDefaultContent($page_id = false, $slug = 'links', $page_name = false)
    {
        $options = get_option(self::getPageOptionKey($page_id));
        if(empty($options)) {
            $dbOptions = self::getPage(false, $page_id);
            $options = array_merge($dbOptions, [
                'page_name' => !empty($page_name) ? $page_name : __('Default page', 'linky'),
                'global' => [
                    'slug' => $slug,
                    'categories' => self::getDefaultCategories(),
                    'labels' => self::getDefaultLabels(),
                ],
                'appareance' => [],
                'themes' => [
                    'header_theme' => 'default',
                    'body_theme' => 'default',
                ]
            ]);

            $options['appareance'] = ThemesHelper::prepareThemeOverride($options);
            $options['appareance']['social_display']  = 'no';

            update_option(self::getPageOptionKey($page_id), $options);
            flush_rewrite_rules(true);
        }
    }

    /**
     * Get Next Page ID
     *
     * @return int
     */
    public static function getNextPageId()
    {
        $pageId = intval(get_option('linky_next_page_id'));
        update_option('linky_next_page_id', $pageId + 1);

        return $pageId + 1;
    }

    /**
     * Remove page
     */
    public static function removePage($page_id)
    {
        delete_option(self::getPageOptionKey($page_id));
    }

    /**
     * Get Google fonts
     */
    public static function getGoogleFonts()
    {
        return json_decode(self::GOOGLE_FONTS);
    }

    /**
     * Get Total Stats
     * @todo
     * @return array;
     */
    public static function getTotals($links = [], $page_id = 0)
    {
        $stats = [
            'global' => [
                'weekly' => [
                    'views' => 0,
                    'clicks' => 0,
                ],
                'monthly' => [
                    'views' => 0,
                    'clicks' => 0,
                ],
                'total' => [
                    'views' => 0,
                    'clicks' => 0,
                ],
            ]
        ];

        foreach($links as &$link) {
            if(empty($link['link']) || $link['type'] == 'separator')
                continue;

            $link_stat = get_option('link_stat_' . $page_id . '_' . md5($link['link']));
            $link_stat = !empty($link_stat) ? $link_stat : [];

            $link['monthly_count']  = count(array_filter($link_stat, function($v) {
                return $v > strtotime("-1 month");
            }));

            $link['weekly_count']   = count(array_filter($link_stat, function($v) {
                return $v > strtotime("-1 week");
            }));

            $link['total_count']    = count($link_stat);

            $stats['global']['weekly']['clicks']    += $link['weekly_count'];
            $stats['global']['monthly']['clicks']   += $link['monthly_count'];
            $stats['global']['total']['clicks']     += $link['total_count'];
        }

        $page_stat = get_option('page_stat_' . $page_id);
        $page_stat = !empty($page_stat) ? $page_stat : [];

        $stats['global']['total']['views']      = count($page_stat);

        $stats['global']['weekly']['views']     = count(array_filter($page_stat, function($v) {
            return $v > strtotime("-1 week");
        }));
        $stats['global']['monthly']['views']    = count(array_filter($page_stat, function($v) {
            return $v > strtotime("-1 month");
        }));

        $stats['links'] = $links;

        return $stats;
    }
}
