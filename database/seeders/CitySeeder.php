<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $citiesUS = [
            ["New York", "نيويورك"],
            ["Los Angeles", "لوس أنجلوس"],
            ["Chicago", "شيكاغو"],
            ["Houston", "هيوستن"],
            ["Phoenix", "فينيكس"],
            ["Philadelphia", "فيلادلفيا"],
            ["San Antonio", "سان أنطونيو"],
            ["San Diego", "سان دييغو"],
            ["Dallas", "دالاس"],
            ["San Jose", "سان خوسيه"],
            ["Austin", "أوستن"],
            ["Jacksonville", "جاكسونفيل"],
            ["San Francisco", "سان فرانسيسكو"],
            ["Indianapolis", "إنديانابوليس"],
            ["Columbus", "كولومبوس"],
            ["Fort Worth", "فورت وورث"],
            ["Charlotte", "شارلوت"],
            ["Seattle", "سياتل"],
            ["Denver", "دينفر"],
            ["Washington", "واشنطن"],
            ["Boston", "بوسطن"],
            ["El Paso", "إل باسو"],
            ["Nashville", "ناشفيل"],
            ["Detroit", "ديترويت"],
            ["Portland", "بورتلاند"],
            ["Memphis", "ممفيس"],
            ["Oklahoma City", "مدينة أوكلاهوما"],
            ["Las Vegas", "لاس فيغاس"],
            ["Louisville", "لويفيل"],
            ["Baltimore", "بالتيمور"],
            ["Milwaukee", "ميلووكي"],
            ["Albuquerque", "ألباكركي"],
            ["Tucson", "توسون"],
            ["Fresno", "فريسنو"],
            ["Mesa", "ميسا"],
            ["Kansas City", "مدينة كانساس"],
            ["Atlanta", "أتلانتا"],
            ["Long Beach", "لونغ بيتش"],
            ["Omaha", "أوماها"],
            ["Raleigh", "رالي"],
            ["Colorado Springs", "كولورادو سبرينغز"],
            ["Miami", "ميامي"],
            ["Virginia Beach", "فيرجينيا بيتش"],
            ["Oakland", "أوكلاند"],
            ["Minneapolis", "مينيابوليس"],
            ["Tulsa", "تولسا"],
            ["Arlington", "أرلينغتون"],
            ["New Orleans", "نيو أورليانز"],
            ["Wichita", "ويتشيتا"],
            ["Cleveland", "كليفلاند"],
            ["Tampa", "تامبا"],
            ["Bakersfield", "باكرسفيلد"],
            ["Aurora", "أورورا"],
            ["Anaheim", "أنهايم"],
            ["Honolulu", "هونولولو"],
            ["Santa Ana", "سانتا آنا"],
            ["Riverside", "ريفرسايد"],
            ["Corpus Christi", "كوربوس كريستي"],
            ["Lexington", "ليكسينغتون"],
            ["Stockton", "ستوكتون"],
            ["Henderson", "هندرسون"],
            ["Saint Paul", "سانت بول"],
            ["Cincinnati", "سينسيناتي"],
            ["St. Louis", "سانت لويس"],
            ["Pittsburgh", "بتسبرغ"],
            ["Greensboro", "جرينزبورو"],
            ["Lincoln", "لينكولن"],
            ["Anchorage", "أنكوراج"],
            ["Plano", "بلانو"],
            ["Orlando", "أورلاندو"],
            ["Irvine", "إيرفين"],
            ["Newark", "نيوارك"],
            ["Durham", "دورهام"],
            ["Chula Vista", "تشولا فيستا"],
            ["Toledo", "توليدو"],
            ["Fort Wayne", "فورت واين"],
            ["St. Petersburg", "سانت بطرسبرغ"],
            ["Laredo", "لاريدو"],
            ["Jersey City", "جيرسي سيتي"],
            ["Chandler", "تشاندلر"],
            ["Madison", "ماديسون"],
            ["Lubbock", "لوبوك"],
            ["Scottsdale", "سكوتسديل"],
            ["Reno", "رينو"],
            ["Buffalo", "بوفالو"],
            ["Gilbert", "جيلبرت"],
            ["Glendale", "غلينديل"],
            ["North Las Vegas", "شمال لاس فيغاس"],
            ["Winston-Salem", "وينستون-سالم"],
            ["Chesapeake", "تشيسابيك"],
            ["Norfolk", "نورفولك"],
            ["Fremont", "فريمونت"],
            ["Garland", "غارلاند"],
            ["Irving", "إيرفينغ"],
            ["Hialeah", "هياليا"],
            ["Richmond", "ريتشموند"],
            ["Boise", "بويز"],
            ["Spokane", "سبوكان"],
            ["Baton Rouge", "باتون روج"],
            ["Tacoma", "تاكوما"],
            ["San Bernardino", "سان بيرناردينو"],
            ["Modesto", "موديستو"],
            ["Fontana", "فونتانا"],
            ["Des Moines", "دي موين"],
            ["Moreno Valley", "مورينو فالي"],
            ["Santa Clarita", "سانتا كلاريتا"],
            ["Fayetteville", "فاييتفيل"],
            ["Birmingham", "بيرمنغهام"],
            ["Oxnard", "أوكسنارد"],
            ["Rochester", "روتشستر"],
            ["Port St. Lucie", "بورت سانت لوسي"],
            ["Grand Rapids", "غراند رابيدز"],
            ["Huntington Beach", "هانتنغتون بيتش"],
            ["Salt Lake City", "سولت ليك سيتي"],
            ["Tallahassee", "تالاهاسي"],
            ["Huntsville", "هانتسفيل"],
            ["Worcester", "وورسستر"],
            ["Knoxville", "نوكسفيل"],
            ["Grand Prairie", "غراند براري"],
            ["Newport News", "نيوبورت نيوز"],
            ["Brownsville", "براونزفيل"],
            ["Overland Park", "أوفرلاند بارك"],
            ["Santa Rosa", "سانتا روزا"],
            ["Chattanooga", "تشاتانوغا"],
            ["Oceanside", "أوشينسايد"],
            ["Garden Grove", "جاردين غروف"],
            ["Vancouver", "فانكوفر"],
            ["Tempe", "تمبي"],
            ["Springfield", "سبرينغفيلد"],
            ["Cape Coral", "كيب كورال"],
            ["Pembroke Pines", "بيمبروك باينز"],
            ["Sioux Falls", "سو فولز"],
            ["Peoria", "بيوريا"],
            ["Lancaster", "لانكاستر"],
            ["Elk Grove", "إلك جروف"],
            ["Corona", "كورونا"],
            ["Eugene", "يوجين"],
            ["Salem", "سالم"],
            ["Palmdale", "بالمديل"],
            ["Salinas", "ساليناس"],
            ["Springfield", "سبرينغفيلد"],
            ["Pasadena", "باسادينا"],
            ["Fort Collins", "فورت كولينز"],
            ["Hayward", "هايوارد"],
            ["Pomona", "بومونا"],
            ["Cary", "كاري"],
            ["Rockford", "روكفورد"],
            ["Alexandria", "الإسكندرية"],
            ["Escondido", "إسكونديدو"],
            ["McKinney", "مكيني"],
            ["Kansas City", "مدينة كانساس"],
            ["Joliet", "جولييت"],
            ["Sunnyvale", "صنيفيل"],
            ["Torrance", "تورانس"],
            ["Bridgeport", "بريدجبورت"],
            ["Lakewood", "لاكوود"],
            ["Hollywood", "هوليوود"],
            ["Paterson", "باترسون"],
            ["Naperville", "نيبيرفيل"],
            ["Syracuse", "سيراكيوز"],
            ["Mesquite", "ميسكويت"],
            ["Dayton", "ديتون"],
            ["Savannah", "سافانا"],
            ["Clarksville", "كلاركسفيل"],
            ["Orange", "أورانج"],
            ["Pasadena", "باسادينا"],
            ["Fullerton", "فوليرتون"],
            ["Killeen", "كيلين"],
            ["Frisco", "فريسكو"],
            ["Hampton", "هامبتون"],
            ["McAllen", "ماكالين"],
            ["Warren", "وارن"],
            ["Bellevue", "بلفيو"],
            ["West Valley City", "ويست فالي سيتي"],
            ["Columbia", "كولومبيا"],
            ["Olathe", "أولايث"],
            ["Sterling Heights", "ستيرلينغ هايتس"],
            ["New Haven", "نيو هيفن"],
            ["Miramar", "ميرامار"],
            ["Waco", "واكو"],
            ["Thousand Oaks", "ألف أوكس"],
            ["Cedar Rapids", "سيدار رابيدس"],
            ["Charleston", "تشارلستون"],
            ["Visalia", "فيساليا"],
            ["Topeka", "توبيكا"],
            ["Elizabeth", "إليزابيث"],
            ["Gainesville", "غاينسفيل"],
            ["Thornton", "ثورنتون"],
            ["Roseville", "روزفيل"],
            ["Carrollton", "كارولتون"],
            ["Coral Springs", "كورال سبرينغس"],
            ["Stamford", "ستامفورد"],
            ["Simi Valley", "سيمي فالي"],
            ["Concord", "كونكورد"],
            ["Hartford", "هارتفورد"],
            ["Kent", "كينت"],
            ["Lafayette", "لافاييت"],
            ["Midland", "ميدلاند"],
            ["Surprise", "سبرايز"],
            ["Denton", "دنتون"],
            ["Victorville", "فيكتورفيل"],
            ["Evansville", "إيفانزفيل"],
            ["Santa Clara", "سانتا كلارا"],
            ["Abilene", "أبيلين"],
            ["Athens", "أثينا"],
            ["Vallejo", "فاليخو"],
            ["Allentown", "ألنتاون"],
            ["Norman", "نورمان"],
            ["Beaumont", "بومونت"],
            ["Independence", "استقلال"],
            ["Murfreesboro", "ميرفريسبورو"],
            ["Ann Arbor", "آن آربر"],
            ["Springfield", "سبرينغفيلد"],
            ["Berkeley", "بركلي"],
            ["Peoria", "بيوريا"],
            ["Provo", "بروفو"],
            ["El Monte", "إل مونتي"],
            ["Columbia", "كولومبيا"],
            ["Lansing", "لانسينغ"],
            ["Fargo", "فارغو"],
            ["Downey", "داوني"],
            ["Costa Mesa", "كوستا ميسا"],
            ["Wilmington", "ويلمنجتون"],
            ["Arvada", "أرفادا"],
            ["Inglewood", "إنجلوود"],
            ["Miami Gardens", "ميامي غاردنز"],
            ["Carlsbad", "كارلسباد"],
            ["Westminster", "ويستمنستر"],
            ["Rochester", "روتشستر"],
            ["Odessa", "أوديسا"],
            ["Manchester", "مانشستر"],
            ["Elgin", "إلجين"],
            ["West Jordan", "ويست جوردان"],
            ["Round Rock", "راوند روك"],
            ["Clearwater", "كليرووتر"],
            ["Waterbury", "ووتربري"],
            ["Gresham", "غريشام"],
            ["Fairfield", "فيرفيلد"],
            ["Billings", "بيلينجز"],
            ["Lowell", "لويل"],
            ["San Buenaventura (Ventura)", "سان بوينافنتورا (فينتورا)"],
            ["Pueblo", "بويبلو"],
            ["High Point", "هاي بوينت"],
            ["West Covina", "ويست كوفينا"],
            ["Richmond", "ريتشموند"],
            ["Murrieta", "موريتا"],
            ["Cambridge", "كامبردج"],
            ["Antioch", "أنتيوك"],
            ["Temecula", "تيميكولا"],
            ["Norwalk", "نورواك"],
            ["Centennial", "سينتينيال"],
            ["Everett", "إيفيريت"],
            ["Palm Bay", "بالم باي"],
            ["Wichita Falls", "ويتشيتا فولز"],
            ["Burbank", "بوربانك"],
            ["Daly City", "ديلي سيتي"],
            ["Gresham", "غريشام"],
            ["Pompano Beach", "بومبانو بيتش"],
            ["Broken Arrow", "بروكن آرو"],
            ["Sandy Springs", "ساندي سبرينغز"],
            ["Rialto", "ريالتو"],
            ["Las Cruces", "لاس كروسيس"],
            ["Lewisville", "لويسفيل"],
            ["Tyler", "تايلر"],
            ["San Mateo", "سان ماتيو"],
            ["Green Bay", "غرين باي"],
            ["League City", "ليج سيتي"],
            ["Bend", "بند"],
            ["Davenport", "دافنبورت"],
            ["South Bend", "ساوث بند"],
            ["Vista", "فيستا"],
            ["Greeley", "غريلى"],
            ["Davie", "دافي"],
            ["Jurupa Valley", "جوروبا فالي"],
            ["Kennewick", "كينيويك"],
            ["Hesperia", "هيسبريا"],
            ["Vacaville", "فاكافيل"],
            ["El Cajon", "إل كاخون"],
            ["Tuscaloosa", "توسكالوسا"],
            ["Edison", "إديسون"],
            ["Santa Maria", "سانتا ماريا"],
            ["Santa Barbara", "سانتا باربرا"],
            ["Renton", "رينتون"],
            ["Clinton", "كلينتون"],
            ["Brockton", "بروكتون"],
            ["Quincy", "كوينسي"],
            ["San Angelo", "سان أنجيلو"],
            ["Odessa", "أوديسا"],
            ["Buena Park", "بوينا بارك"],
            ["Palm Coast", "بالم كوست"],
            ["St. George", "سانت جورج"],
            ["Lakeland", "لاكلاند"],
            ["Hemet", "هيمت"],
            ["Nashua", "ناشوا"],
            ["Union City", "يونيون سيتي"],
            ["Marysville", "ماريسفيل"],
            ["Lawrence", "لورانس"],
            ["Cranston", "كرانستون"],
            ["Schaumburg", "شومبورغ"],
            ["Edinburg", "إدينبرغ"],
            ["Bellflower", "بلفلاور"],
            ["Milpitas", "ميلبيتاس"],
            ["Bloomington", "بلومينغتون"],
            ["Toms River", "تومز ريفر"],
            ["Westland", "ويستلاند"],
            ["Kirkland", "كيركلاند"],
            ["Yuma", "يوما"],
            ["Manhattan", "مانهاتن"],
            ["San Leandro", "سان لياندرو"],
            ["Cupertino", "كوبرتينو"],
            ["Springfield", "سبرينغفيلد"],
            ["Portsmouth", "بورتسموث"],
            ["Warner Robins", "وارنر روبنز"],
            ["Orem", "أوريم"],
            ["Dearborn", "ديربورن"],
            ["Livonia", "ليفونيا"],
            ["Carmel", "كارميل"],
            ["Iowa City", "مدينة آيوا"],
            ["New Bedford", "نيو بدفورد"],
            ["Santa Fe", "سانتا في"],
            ["Sparks", "سباركس"],
            ["Lynn", "لين"],
            ["Sugar Land", "سوجار لاند"],
            ["Hillsboro", "هيلسبرو"],
            ["Rio Rancho", "ريو رانشو"],
            ["Roanoke", "روانوك"],
            ["Kenner", "كينير"],
            ["Cicero", "سيسرو"],
            ["Kalamazoo", "كالامازو"],
            ["Shreveport", "شريف بورت"],
            ["Salem", "سالم"],
            ["Lawton", "لوتن"]
        ];

        foreach($citiesUS as $citiesUSList){
            $location = $this->latLng($citiesUSList[0]);
            $city = new City();
            $city->country_id = 187;
            $city->name = $citiesUSList[0];
            $city->name_ar = $citiesUSList[1];
            $city->lat = $location['lat'] ?? null;
            $city->lng = $location['lng'] ?? null;
            $city->save();
        }


        $citiesSaudiArabics = [
            ['Riyadh', 'الرياض'],
            ['Jeddah', 'جدة'],
            ['Mecca', 'مكة'],
            ['Medina', 'المدينة'],
            ['Dammam', 'الدمام'],
            ['Tabuk', 'تبوك'],
            ['Buraidah', 'بريدة'],
            ['Khamis Mushait', 'خميس مشيط'],
            ['Hail', 'حائل'],
            ['Najran', 'نجران'],
            ['Al Khobar', 'الخبر'],
            ['Taif', 'الطائف'],
            ['Yanbu', 'ينبع'],
            ['Abha', 'أبها'],
            ['Jizan', 'جازان'],
            ['Al Jubail', 'الجبيل'],
            ['Arar', 'عرعر'],
            ['Al Qunfudhah', 'القنفذة'],
            ['Al Kharj', 'الخرج'],
            ['Al Hufuf', 'الهفوف'],
            ['Rafha', 'رفحاء']
        ];

        foreach($citiesSaudiArabics as $citiesSaudiArabic){
            $location = $this->latLng($citiesSaudiArabic[0]);
            $city = new City();
            $city->country_id = 153;
            $city->name = $citiesSaudiArabic[0];
            $city->name_ar = $citiesSaudiArabic[1];
            $city->lat = $location['lat'] ?? null;
            $city->lng = $location['lng'] ?? null;
            $city->save();
        }

        $kuwait_cities = [
            ['Kuwait City', 'مدينة الكويت'],
            ['Hawalli', 'حولي'],
            ['Salmiya', 'السالمية'],
            ['Farwaniya', 'الفروانية'],
            ['Al Jahra', 'الجهراء'],
            ['Mubarak Al-Kabeer', 'مبارك الكبير'],
            ['Ahmadi', 'الأحمدي'],
            ['Al-Fintas', 'الفنطاس'],
            ['Sabah Al-Salem', 'صباح السالم'],
            ['Al-Ahmadi', 'الأحمدي']
        ];

        foreach($kuwait_cities as $kuwait_citie){
            $location = $this->latLng($kuwait_citie[0]);
            $city = new City();
            $city->country_id = 93;
            $city->name = $kuwait_citie[0];
            $city->name_ar = $kuwait_citie[1];
            $city->lat = $location['lat'] ?? null;
            $city->lng = $location['lng'] ?? null;
            $city->save();
        }

        $qatar_cities = [
            ['Doha', 'الدوحة'],
            ['Al Wakrah', 'الوكرة'],
            ['Al Rayyan', 'الريان'],
            ['Umm Salal', 'أم صلال'],
            ['Al Khor', 'الخور'],
            ['Al Shamal', 'الشمال'],
            ['Mesaieed', 'مسيعيد']

        ];

        foreach($qatar_cities as $qatar_citie){

            $location = $this->latLng($qatar_citie[0]);
            $city = new City();
            $city->country_id = 143;
            $city->name = $qatar_citie[0];
            $city->name_ar = $qatar_citie[1];
            $city->lat = $location['lat'] ?? null;
            $city->lng = $location['lng'] ?? null;
            $city->save();
        }
    }

    public function latLng($cityName)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json?address=$cityName&key=$apiKey");
        $data = json_decode($response, true);
        if ($data['status'] === 'OK') {
            $location = $data['results'][0]['geometry']['location'];
            return $location;
        } else {

        }
    }
}
