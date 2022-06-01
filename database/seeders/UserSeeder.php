<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Cristian',
            'lastname' => 'Gómez Nevado',
            'email' => 'cgomez@milaifontanals.org',
            'password' => '1234',
            'birthdate' => date_create('1997-05-08'),
            'gender' => 'male',
            'blocked' => false,
            'country_id' => Country::where('code', 'ES')->first()->id
        ]);


        #region Users
        $users = [
            [
                "name" => "Rafi",
                "lastname" => "Oaten",
                "email" => "rafi@nature.com",
                "gender" => "female",
                "password" => "1234",
                "birthdate" => "1994-07-31",
                "country_id" => Country::where('code', 'US')->first()->id
            ],
            [
                "name" => "Seka",
                "lastname" => "Teece",
                "email" => "steece1@123-reg.co.uk",
                "gender" => "male",
                "password" => "b3PTWJ2",
                "birthdate" => "1967-02-07",
                "country_id" => Country::where('code', 'GT')->first()->id
            ],
            [
                "name" => "Cobbie",
                "lastname" => "Ferrari",
                "email" => "cferrari2@ifeng.com",
                "gender" => "not_specified",
                "password" => "duQ01PLab4Z",
                "birthdate" => "1943-11-04",
                "country_id" => Country::where('code', 'KR')->first()->id
            ],
            [
                "name" => "Arron",
                "lastname" => "MacCahey",
                "email" => "amaccahey3@weebly.com",
                "gender" => "not_specified",
                "password" => "wv2mdk0nC",
                "birthdate" => "1989-07-24",
                "country_id" => Country::where('code', 'ID')->first()->id
            ],
            [
                "name" => "Shel",
                "lastname" => "Beckham",
                "email" => "sbeckham4@buzzfeed.com",
                "gender" => "not_specified",
                "password" => "iyRdcNfQJjM",
                "birthdate" => "1993-01-17",
                "country_id" => Country::where('code', 'PH')->first()->id
            ],
            [
                "name" => "Elisabet",
                "lastname" => "Pawlaczyk",
                "email" => "epawlaczyk5@mashable.com",
                "gender" => "female",
                "password" => "wHHxrm",
                "birthdate" => "1995-08-19",
                "country_id" => Country::where('code', 'NL')->first()->id
            ],
            [
                "name" => "Danni",
                "lastname" => "Suddaby",
                "email" => "dsuddaby6@nasa.gov",
                "gender" => "male",
                "password" => "BHGdMIlEd",
                "birthdate" => "1979-10-23",
                "country_id" => Country::where('code', 'ID')->first()->id
            ],
            [
                "name" => "Brooke",
                "lastname" => "Pershouse",
                "email" => "bpershouse7@adobe.com",
                "gender" => "female",
                "password" => "bNOSFnU",
                "birthdate" => "1943-03-04",
                "country_id" => Country::where('code', 'CA')->first()->id
            ],
            [
                "name" => "Mordy",
                "lastname" => "Saunter",
                "email" => "msaunter8@nih.gov",
                "gender" => "female",
                "password" => "tM39kVp",
                "birthdate" => "1989-03-16",
                "country_id" => Country::where('code', 'RU')->first()->id
            ],
            [
                "name" => "Gabie",
                "lastname" => "Derell",
                "email" => "gderell9@yahoo.co.jp",
                "gender" => "male",
                "password" => "5zzZIX0",
                "birthdate" => "1946-01-21",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Sydel",
                "lastname" => "Dabner",
                "email" => "sdabnera@yandex.ru",
                "gender" => "not_specified",
                "password" => "sP5Fmr",
                "birthdate" => "1974-01-07",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Sue",
                "lastname" => "Pendock",
                "email" => "spendockb@amazonaws.com",
                "gender" => "male",
                "password" => "JFoDNbEeO",
                "birthdate" => "1995-06-07",
                "country_id" => Country::where('code', 'ID')->first()->id
            ],
            [
                "name" => "Karla",
                "lastname" => "McCormack",
                "email" => "kmccormackc@arstechnica.com",
                "gender" => "male",
                "password" => "l7tOIDD5",
                "birthdate" => "1975-10-03",
                "country_id" => Country::where('code', 'ID')->first()->id
            ],
            [
                "name" => "William",
                "lastname" => "Awmack",
                "email" => "wawmackd@who.int",
                "gender" => "not_specified",
                "password" => "68MnaqZS",
                "birthdate" => "2002-12-09",
                "country_id" => Country::where('code', 'YE')->first()->id
            ],
            [
                "name" => "Glori",
                "lastname" => "Clague",
                "email" => "gclaguee@zdnet.com",
                "gender" => "male",
                "password" => "CG254QtkGd",
                "birthdate" => "1976-03-03",
                "country_id" => Country::where('code', 'ID')->first()->id
            ],
            [
                "name" => "Cindee",
                "lastname" => "Willsmore",
                "email" => "cwillsmoref@netvibes.com",
                "gender" => "male",
                "password" => "um1FifDZvuK",
                "birthdate" => "1940-06-12",
                "country_id" => Country::where('code', 'ET')->first()->id
            ],
            [
                "name" => "Ulick",
                "lastname" => "Chimes",
                "email" => "uchimesg@4shared.com",
                "gender" => "male",
                "password" => "rDKHdei0G4B",
                "birthdate" => "1980-07-07",
                "country_id" => Country::where('code', 'NG')->first()->id
            ],
            [
                "name" => "Felicdad",
                "lastname" => "MacKenney",
                "email" => "fmackenneyh@europa.eu",
                "gender" => "not_specified",
                "password" => "HXzcAi",
                "birthdate" => "1972-07-20",
                "country_id" => Country::where('code', 'KZ')->first()->id
            ],
            [
                "name" => "Frederico",
                "lastname" => "Kerrich",
                "email" => "fkerrichi@addthis.com",
                "gender" => "female",
                "password" => "cOJmi4Pe",
                "birthdate" => "1940-05-25",
                "country_id" => Country::where('code', 'ID')->first()->id
            ],
            [
                "name" => "Osmund",
                "lastname" => "Goosey",
                "email" => "ogooseyj@amazonaws.com",
                "gender" => "female",
                "password" => "UiMvUO",
                "birthdate" => "1997-05-19",
                "country_id" => Country::where('code', 'PT')->first()->id
            ],
            [
                "name" => "Katherina",
                "lastname" => "Rooke",
                "email" => "krookek@ning.com",
                "gender" => "other",
                "password" => "RicJF0OA",
                "birthdate" => "2000-04-24",
                "country_id" => Country::where('code', 'PT')->first()->id
            ],
            [
                "name" => "Willi",
                "lastname" => "Biggs",
                "email" => "wbiggsl@lulu.com",
                "gender" => "female",
                "password" => "baamfnJPsBC",
                "birthdate" => "1934-04-15",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Minda",
                "lastname" => "Fullerlove",
                "email" => "mfullerlovem@intel.com",
                "gender" => "male",
                "password" => "Af9Y0hvDgAnn",
                "birthdate" => "1954-04-11",
                "country_id" => Country::where('code', 'ZA')->first()->id
            ],
            [
                "name" => "Ingrim",
                "lastname" => "Dedon",
                "email" => "idedonn@linkedin.com",
                "gender" => "male",
                "password" => "Pkh7CPQDFjX4",
                "birthdate" => "1944-12-27",
                "country_id" => Country::where('code', 'ID')->first()->id
            ],
            [
                "name" => "Adam",
                "lastname" => "Orrock",
                "email" => "aorrocko@icq.com",
                "gender" => "male",
                "password" => "CTz3lNS",
                "birthdate" => "1939-11-21",
                "country_id" => Country::where('code', 'RU')->first()->id
            ],
            [
                "name" => "Willis",
                "lastname" => "Drinkhall",
                "email" => "wdrinkhallp@google.com.hk",
                "gender" => "female",
                "password" => "iu7uRjXQuu",
                "birthdate" => "1922-12-16",
                "country_id" => Country::where('code', 'MA')->first()->id
            ],
            [
                "name" => "Man",
                "lastname" => "Malby",
                "email" => "mmalbyq@comsenz.com",
                "gender" => "other",
                "password" => "pQUQYJd",
                "birthdate" => "2006-10-23",
                "country_id" => Country::where('code', 'HN')->first()->id
            ],
            [
                "name" => "Alon",
                "lastname" => "Fishly",
                "email" => "afishlyr@free.fr",
                "gender" => "other",
                "password" => "w6Hlaz",
                "birthdate" => "1947-01-26",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Kristy",
                "lastname" => "Kilbourn",
                "email" => "kkilbourns@samsung.com",
                "gender" => "female",
                "password" => "buBOzGr",
                "birthdate" => "1938-10-30",
                "country_id" => Country::where('code', 'ID')->first()->id
            ],
            [
                "name" => "Hyacinthia",
                "lastname" => "Carnock",
                "email" => "hcarnockt@linkedin.com",
                "gender" => "female",
                "password" => "32RxDA",
                "birthdate" => "1978-06-14",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Codi",
                "lastname" => "Mault",
                "email" => "cmaultu@trellian.com",
                "gender" => "not_specified",
                "password" => "0N9nOwW",
                "birthdate" => "1952-07-16",
                "country_id" => Country::where('code', 'ID')->first()->id
            ],
            [
                "name" => "Lettie",
                "lastname" => "Hanbidge",
                "email" => "lhanbidgev@chronoengine.com",
                "gender" => "female",
                "password" => "otPXf49RvNB",
                "birthdate" => "1944-12-31",
                "country_id" => Country::where('code', 'TH')->first()->id
            ],
            [
                "name" => "Astrix",
                "lastname" => "Bread",
                "email" => "abreadw@alibaba.com",
                "gender" => "other",
                "password" => "wQ3HTXd",
                "birthdate" => "1959-08-28",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Doreen",
                "lastname" => "Cadwaladr",
                "email" => "dcadwaladrx@mtv.com",
                "gender" => "not_specified",
                "password" => "ihsV0qisy",
                "birthdate" => "1988-09-26",
                "country_id" => Country::where('code', 'ZW')->first()->id
            ],
            [
                "name" => "Alex",
                "lastname" => "Chantillon",
                "email" => "achantillony@washington.edu",
                "gender" => "other",
                "password" => "2etPREeIDyI",
                "birthdate" => "1936-06-11",
                "country_id" => Country::where('code', 'CZ')->first()->id
            ],
            [
                "name" => "Georgette",
                "lastname" => "Pragnall",
                "email" => "gpragnallz@wired.com",
                "gender" => "other",
                "password" => "slLjfJCL",
                "birthdate" => "1965-08-18",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Waite",
                "lastname" => "Fisk",
                "email" => "wfisk10@xrea.com",
                "gender" => "not_specified",
                "password" => "aaczZrhPEnA",
                "birthdate" => "1940-07-14",
                "country_id" => Country::where('code', 'PE')->first()->id
            ],
            [
                "name" => "Merridie",
                "lastname" => "Darridon",
                "email" => "mdarridon11@sciencedaily.com",
                "gender" => "other",
                "password" => "fpSwr8MW",
                "birthdate" => "2005-03-02",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Jacqui",
                "lastname" => "McFadden",
                "email" => "jmcfadden12@sitemeter.com",
                "gender" => "not_specified",
                "password" => "E9qXpv",
                "birthdate" => "1966-11-06",
                "country_id" => Country::where('code', 'ID')->first()->id
            ],
            [
                "name" => "Hadley",
                "lastname" => "Stennes",
                "email" => "hstennes13@de.vu",
                "gender" => "male",
                "password" => "ovKzf5",
                "birthdate" => "2008-10-16",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Emelina",
                "lastname" => "Scollick",
                "email" => "escollick14@shareasale.com",
                "gender" => "other",
                "password" => "cgKLtDY5Qw0H",
                "birthdate" => "1929-01-30",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Orin",
                "lastname" => "Arundel",
                "email" => "oarundel15@prweb.com",
                "gender" => "female",
                "password" => "JwYMr0QnErG",
                "birthdate" => "1998-11-16",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Merle",
                "lastname" => "Quince",
                "email" => "mquince16@statcounter.com",
                "gender" => "not_specified",
                "password" => "upJuJjLuGC",
                "birthdate" => "1965-05-28",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Lukas",
                "lastname" => "O'Clery",
                "email" => "loclery17@kickstarter.com",
                "gender" => "not_specified",
                "password" => "uUxXDA204Y",
                "birthdate" => "1992-07-28",
                "country_id" => Country::where('code', 'GR')->first()->id
            ],
            [
                "name" => "Petey",
                "lastname" => "Whiteside",
                "email" => "pwhiteside18@theglobeandmail.com",
                "gender" => "female",
                "password" => "BLo2CqX",
                "birthdate" => "2007-03-04",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Bidget",
                "lastname" => "Beddin",
                "email" => "bbeddin19@freewebs.com",
                "gender" => "other",
                "password" => "Yg3v0skNfS7O",
                "birthdate" => "1929-03-16",
                "country_id" => Country::where('code', 'CN')->first()->id
            ],
            [
                "name" => "Bryce",
                "lastname" => "Breadon",
                "email" => "bbreadon1a@hibu.com",
                "gender" => "male",
                "password" => "6VTfe1",
                "birthdate" => "2000-04-14",
                "country_id" => Country::where('code', 'PK')->first()->id
            ],
            [
                "name" => "Suzanne",
                "lastname" => "Dearth",
                "email" => "sdearth1b@delicious.com",
                "gender" => "other",
                "password" => "XD3nZeH9rpew",
                "birthdate" => "1937-02-18",
                "country_id" => Country::where('code', 'RU')->first()->id
            ],
            [
                "name" => "Giselbert",
                "lastname" => "Bunworth",
                "email" => "gbunworth1c@qq.com",
                "gender" => "female",
                "password" => "DZ10Bd3uQp",
                "birthdate" => "1943-03-24",
                "country_id" => Country::where('code', 'ID')->first()->id
            ],
            [
                "name" => "Coretta",
                "lastname" => "Colbertson",
                "email" => "ccolbertson1d@go.com",
                "gender" => "other",
                "password" => "ieFhNRZo",
                "birthdate" => "2009-05-11",
                "country_id" => Country::where('code', 'PH')->first()->id
            ]
        ];
        #endregion

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
