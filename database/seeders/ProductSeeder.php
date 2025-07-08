<?php

namespace Database\Seeders;

use App\Enums\Media\ProductMediaEnum;
use App\Helpers\ImageDownloader;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $categories = Category::all();

                $products = [
                    ['name' => ['en' => 'Wireless Bluetooth Headphones', 'ar' => 'سماعات بلوتوث لاسلكية'], 'description' => ['en' => 'High-quality wireless headphones with noise cancellation and long battery life.', 'ar' => 'سماعات بلوتوث عالية الجودة مع إلغاء الضوضاء وطاقة بطارية طويلة الأمد.'], 'price' => 89.99, 'quantity' => 50, 'slug' => 'wireless-bluetooth-headphones-0'],
                    ['name' => ['en' => 'Smart LED Bulb', 'ar' => 'مصباح LED ذكي'], 'description' => ['en' => 'Energy-efficient smart bulb compatible with Alexa and Google Home.', 'ar' => 'مصباح LED ذكي فعال في استهلاك الطاقة يدعم Alexa وGoogle Home.'], 'price' => 19.95, 'quantity' => 75, 'slug' => 'smart-led-bulb-1'],
                    ['name' => ['en' => 'Stainless Steel Water Bottle', 'ar' => 'قارورة ماء من الفولاذ المقاوم للصدأ'], 'description' => ['en' => 'Durable 750ml water bottle with double-wall insulation.', 'ar' => 'قارورة ماء متينة سعة 750 مل مع عزل بجدران مزدوجة.'], 'price' => 24.50, 'quantity' => 30, 'slug' => 'stainless-steel-water-bottle-2'],
                    ['name' => ['en' => 'Leather Laptop Bag', 'ar' => 'حقيبة لابتوب جلدية'], 'description' => ['en' => 'Premium leather bag designed for 15-inch laptops.', 'ar' => 'حقيبة جلدية فاخرة مصممة لأجهزة لابتوب 15 بوصة.'], 'price' => 129.00, 'quantity' => 20, 'slug' => 'leather-laptop-bag-3'],
                    ['name' => ['en' => 'Organic Green Tea', 'ar' => 'شاي أخضر عضوي'], 'description' => ['en' => '100g pack of organic green tea with natural antioxidants.', 'ar' => 'عبوة 100 غرام من شاي أخضر عضوي تحتوي على مضادات أكسدة طبيعية.'], 'price' => 12.99, 'quantity' => 100, 'slug' => 'organic-green-tea-4'],
                    ['name' => ['en' => 'Gaming Mouse Pad', 'ar' => 'حصيرة فأرة للألعاب'], 'description' => ['en' => 'Large non-slip mouse pad with smooth surface for gaming.', 'ar' => 'حصيرة فأرة كبيرة غير قابلة للانزلاق بمظهر سلس للألعاب.'], 'price' => 15.75, 'quantity' => 60, 'slug' => 'gaming-mouse-pad-5'],
                    ['name' => ['en' => 'Cotton T-Shirt', 'ar' => 'تي شيرت قطني'], 'description' => ['en' => 'Comfortable cotton t-shirt available in multiple colors.', 'ar' => 'تي شيرت قطني مريح متوفر بألوان متعددة.'], 'price' => 19.99, 'quantity' => 80, 'slug' => 'cotton-t-shirt-6'],
                    ['name' => ['en' => 'USB-C Charging Cable', 'ar' => 'كابل شحن USB-C'], 'description' => ['en' => 'Durable 2m USB-C cable with fast charging support.', 'ar' => 'كابل USB-C متين بطول 2 متر يدعم الشحن السريع.'], 'price' => 9.99, 'quantity' => 150, 'slug' => 'usb-c-charging-cable-7'],
                    ['name' => ['en' => 'Ergonomic Office Chair', 'ar' => 'كرسي مكتبي أرجونومي'], 'description' => ['en' => 'Adjustable office chair with lumbar support for long hours.', 'ar' => 'كرسي مكتبي قابل للتعديل مع دعم للخصر لساعات طويلة.'], 'price' => 199.50, 'quantity' => 15, 'slug' => 'ergonomic-office-chair-8'],
                    ['name' => ['en' => 'Portable Bluetooth Speaker', 'ar' => 'سماعة بلوتوث محمولة'], 'description' => ['en' => 'Compact speaker with 10-hour battery life and waterproof design.', 'ar' => 'سماعة بلوتوث مدمجة بطاقة بطارية 10 ساعات وتصميم مقاوم للماء.'], 'price' => 39.95, 'quantity' => 40, 'slug' => 'portable-bluetooth-speaker-9'],
                    ['name' => ['en' => 'Running Shoes', 'ar' => 'أحذية رياضية للجري'], 'description' => ['en' => 'Lightweight running shoes with cushioned soles.', 'ar' => 'أحذية رياضية خفيفة الوزن مع أطراف مريحة.'], 'price' => 59.99, 'quantity' => 35, 'slug' => 'running-shoes-10'],
                    ['name' => ['en' => 'Coffee Maker Machine', 'ar' => 'ماكينة تحضير القهوة'], 'description' => ['en' => 'Automatic coffee maker with a 12-cup capacity.', 'ar' => 'ماكينة قهوة آلية بسعة 12 كوب.'], 'price' => 79.00, 'quantity' => 25, 'slug' => 'coffee-maker-machine-11'],
                    ['name' => ['en' => 'Yoga Mat', 'ar' => 'حصيرة يوغا'], 'description' => ['en' => 'Non-slip yoga mat with extra padding for comfort.', 'ar' => 'حصيرة يوغا غير قابلة للانزلاق مع بطانة إضافية للراحة.'], 'price' => 29.50, 'quantity' => 70, 'slug' => 'yoga-mat-12'],
                    ['name' => ['en' => 'External Hard Drive', 'ar' => 'قرص صلب خارجي'], 'description' => ['en' => '1TB external hard drive with fast data transfer speeds.', 'ar' => 'قرص صلب خارجي سعة 1 تيرابايت بسرعات نقل بيانات عالية.'], 'price' => 69.99, 'quantity' => 45, 'slug' => 'external-hard-drive-13'],
                    ['name' => ['en' => 'Digital Camera', 'ar' => 'كاميرا رقمية'], 'description' => ['en' => '12MP digital camera with 4x optical zoom.', 'ar' => 'كاميرا رقمية 12 ميجابكسل مع تكبير بصري 4x.'], 'price' => 149.00, 'quantity' => 20, 'slug' => 'digital-camera-14'],
                    ['name' => ['en' => 'Backpack for Travel', 'ar' => 'حقيبة ظهر للسفر'], 'description' => ['en' => 'Water-resistant backpack with multiple compartments.', 'ar' => 'حقيبة ظهر مقاومة للماء بفواصل متعددة.'], 'price' => 45.00, 'quantity' => 60, 'slug' => 'backpack-for-travel-15'],
                    ['name' => ['en' => 'Electric Kettle', 'ar' => 'غلاية كهربائية'], 'description' => ['en' => '1.7L electric kettle with auto shut-off feature.', 'ar' => 'غلاية كهربائية سعة 1.7 لتر مع خاصية الإغلاق التلقائي.'], 'price' => 29.99, 'quantity' => 50, 'slug' => 'electric-kettle-16'],
                    ['name' => ['en' => 'Fitness Tracker', 'ar' => 'متعقب لياقة'], 'description' => ['en' => 'Waterproof fitness tracker with heart rate monitor.', 'ar' => 'متعقب لياقة مقاوم للماء مع جهاز مراقبة نبضات القلب.'], 'price' => 49.95, 'quantity' => 40, 'slug' => 'fitness-tracker-17'],
                    ['name' => ['en' => 'Wooden Desk Organizer', 'ar' => 'منظم مكتب خشبي'], 'description' => ['en' => 'Elegant wooden organizer for pens and office supplies.', 'ar' => 'منظم مكتب خشبي أنيق للأقلام والمستلزمات المكتبية.'], 'price' => 19.50, 'quantity' => 80, 'slug' => 'wooden-desk-organizer-18'],
                    ['name' => ['en' => 'HD Smart TV', 'ar' => 'تلفزيون ذكي HD'], 'description' => ['en' => '55-inch HD smart TV with built-in streaming apps.', 'ar' => 'تلفزيون ذكي HD بحجم 55 بوصة مع تطبيقات بث مدمجة.'], 'price' => 499.00, 'quantity' => 10, 'slug' => 'hd-smart-tv-19'],
                    ['name' => ['en' => 'Sunglasses for Men', 'ar' => 'نظارات شمسية للرجال'], 'description' => ['en' => 'UV-protected sunglasses with polarized lenses.', 'ar' => 'نظارات شمسية محمية من الأشعة فوق البنفسجية بعدسات متعادلة.'], 'price' => 35.00, 'quantity' => 90, 'slug' => 'sunglasses-for-men-20'],
                    ['name' => ['en' => 'Kitchen Knife Set', 'ar' => 'مجموعة سكاكين مطبخ'], 'description' => ['en' => '5-piece stainless steel knife set with wooden block.', 'ar' => 'مجموعة سكاكين مطبخ من الفولاذ المقاوم للصدأ تحتوي على 5 قطع مع كتلة خشبية.'], 'price' => 89.99, 'quantity' => 25, 'slug' => 'kitchen-knife-set-21'],
                    ['name' => ['en' => 'Wireless Router', 'ar' => 'راوتر لاسلكي'], 'description' => ['en' => 'High-speed dual-band wireless router for home use.', 'ar' => 'راوتر لاسلكي عالي السرعة مزدوج النطاق للاستخدام المنزلي.'], 'price' => 79.50, 'quantity' => 30, 'slug' => 'wireless-router-22'],
                    ['name' => ['en' => 'Perfume for Women', 'ar' => 'عطر للنساء'], 'description' => ['en' => '50ml floral perfume with long-lasting fragrance.', 'ar' => 'عطر زهوري 50 مل بعطر دائم.'], 'price' => 45.99, 'quantity' => 70, 'slug' => 'perfume-for-women-23'],
                    ['name' => ['en' => 'Electric Toothbrush', 'ar' => 'فرشاة أسنان كهربائية'], 'description' => ['en' => 'Rechargeable toothbrush with multiple brushing modes.', 'ar' => 'فرشاة أسنان قابلة لإعادة الشحن بأوضاع تنظيف متعددة.'], 'price' => 39.95, 'quantity' => 60, 'slug' => 'electric-toothbrush-24'],
                    ['name' => ['en' => 'Desk Lamp', 'ar' => 'مصباح مكتب'], 'description' => ['en' => 'Adjustable LED desk lamp with dimming options.', 'ar' => 'مصباح مكتب LED قابل للتعديل مع خيارات الإضاءة المنخفضة.'], 'price' => 24.99, 'quantity' => 50, 'slug' => 'desk-lamp-25'],
                    ['name' => ['en' => 'Gaming Keyboard', 'ar' => 'لوحة مفاتيح للألعاب'], 'description' => ['en' => 'Mechanical gaming keyboard with RGB lighting.', 'ar' => 'لوحة مفاتيح ميكانيكية للألعاب بإضاءة RGB.'], 'price' => 99.00, 'quantity' => 30, 'slug' => 'gaming-keyboard-26'],
                    ['name' => ['en' => 'Cookware Set', 'ar' => 'مجموعة أواني طبخ'], 'description' => ['en' => '10-piece non-stick cookware set with lids.', 'ar' => 'مجموعة أواني طبخ غير لاصقة تحتوي على 10 قطع مع أغطية.'], 'price' => 129.50, 'quantity' => 20, 'slug' => 'cookware-set-27'],
                    ['name' => ['en' => 'Hair Dryer', 'ar' => 'مجفف شعر'], 'description' => ['en' => 'Professional hair dryer with ionic technology.', 'ar' => 'مجفف شعر احترافي بتقنية الأيونات.'], 'price' => 49.99, 'quantity' => 40, 'slug' => 'hair-dryer-28'],
                    ['name' => ['en' => 'Travel Pillow', 'ar' => 'وسادة سفر'], 'description' => ['en' => 'Memory foam travel pillow for neck support.', 'ar' => 'وسادة سفر من رغوة الذاكرة لدعم الرقبة.'], 'price' => 19.95, 'quantity' => 80, 'slug' => 'travel-pillow-29'],
                    ['name' => ['en' => 'Smart Watch', 'ar' => 'ساعة ذكية'], 'description' => ['en' => 'Smart watch with fitness tracking and notifications.', 'ar' => 'ساعة ذكية بتتبع اللياقة وإشعارات.'], 'price' => 79.99, 'quantity' => 35, 'slug' => 'smart-watch-30'],
                    ['name' => ['en' => 'Blender', 'ar' => 'خلاط'], 'description' => ['en' => 'Powerful blender with 600W motor and multiple speeds.', 'ar' => 'خلاط قوي بمحرك 600 واط وسرعات متعددة.'], 'price' => 59.50, 'quantity' => 25, 'slug' => 'blender-31'],
                    ['name' => ['en' => 'Wall Clock', 'ar' => 'ساعة حائط'], 'description' => ['en' => 'Modern wall clock with silent movement.', 'ar' => 'ساعة حائط حديثة بحركة صامتة.'], 'price' => 29.99, 'quantity' => 50, 'slug' => 'wall-clock-32'],
                    ['name' => ['en' => 'Sports Bag', 'ar' => 'حقيبة رياضية'], 'description' => ['en' => 'Durable sports bag with ventilated shoe compartment.', 'ar' => 'حقيبة رياضية متينة بفاصل تنفس للأحذية.'], 'price' => 39.95, 'quantity' => 45, 'slug' => 'sports-bag-33'],
                    ['name' => ['en' => 'Notebook Set', 'ar' => 'مجموعة دفاتر'], 'description' => ['en' => 'Set of 3 premium notebooks with lined pages.', 'ar' => 'مجموعة من 3 دفاتر فاخرة بصفحات مخططة.'], 'price' => 15.00, 'quantity' => 90, 'slug' => 'notebook-set-34'],
                    ['name' => ['en' => 'Air Purifier', 'ar' => 'منقي هواء'], 'description' => ['en' => 'Compact air purifier with HEPA filter.', 'ar' => 'منقي هواء مدمج بمرشح HEPA.'], 'price' => 99.99, 'quantity' => 20, 'slug' => 'air-purifier-35'],
                    ['name' => ['en' => 'Umbrella', 'ar' => 'مظلة'], 'description' => ['en' => 'Windproof umbrella with automatic open/close feature.', 'ar' => 'مظلة مقاومة للرياح بخاصية الفتح والإغلاق التلقائي.'], 'price' => 19.50, 'quantity' => 70, 'slug' => 'umbrella-36'],
                    ['name' => ['en' => 'Power Bank', 'ar' => 'بنك طاقة'], 'description' => ['en' => '10000mAh power bank with dual USB ports.', 'ar' => 'بنك طاقة 10000mAh بمنافذ USB مزدوجة.'], 'price' => 29.95, 'quantity' => 60, 'slug' => 'power-bank-37'],
                    ['name' => ['en' => 'Dinnerware Set', 'ar' => 'مجموعة أطباق الطعام'], 'description' => ['en' => '16-piece ceramic dinnerware set for 4 people.', 'ar' => 'مجموعة أطباق طعام سيراميك تحتوي على 16 قطعة لـ 4 أشخاص.'], 'price' => 79.00, 'quantity' => 30, 'slug' => 'dinnerware-set-38'],
                    ['name' => ['en' => 'Kids Toy Car', 'ar' => 'سيارة ألعاب للأطفال'], 'description' => ['en' => 'Battery-operated toy car with lights and sounds.', 'ar' => 'سيارة ألعاب تعمل بالبطارية مع أضواء وأصوات.'], 'price' => 24.99, 'quantity' => 50, 'slug' => 'kids-toy-car-39'],
                ];

                foreach ($products as $index => $productData) {
                    $product = Product::create([
                        'name' => $productData['name'],
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'quantity' => $productData['quantity'],
                        'status' => 'active',
                        'slug' => $productData['slug'],
                    ]);

                    // Download and attach main image
                    $imageUrl = ImageDownloader::getProductImageUrl($index);
                    $imagePath = ImageDownloader::downloadImage(
                        $imageUrl, 
                        "product-{$index}.jpg"
                    );
                    
                    // Add main image to media collection
                    $product->addMediaFromDisk($imagePath, 'public')
                        ->toMediaCollection(ProductMediaEnum::MAIN_IMAGE->value);

                    // Add some gallery images (2-4 images)
                    $galleryCount = rand(2, 4);
                    for ($i = 0; $i < $galleryCount; $i++) {
                        $galleryImageUrl = ImageDownloader::getProductImageUrl($index + $i + 100); // Different random images
                        $galleryImagePath = ImageDownloader::downloadImage(
                            $galleryImageUrl, 
                            "product-{$index}-gallery-{$i}.jpg"
                        );
                        
                        $product->addMediaFromDisk($galleryImagePath, 'public')
                            ->toMediaCollection(ProductMediaEnum::GALLERY->value);
                    }

                    // Attach random categories
                    $product->categories()->attach(
                        $categories->random(rand(1, 2))->pluck('id')->toArray()
                    );
                }
            }
}
