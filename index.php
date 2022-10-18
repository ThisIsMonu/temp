<?php
readCsvFile("Sheet1.csv");
// print_r(readCsvFile("Sheet1.csv"));

function readCsvFile($path)
{
  $array_keys = [
    "slug",
    "post_title",
    "language",
    "gi_main_category",
    "gi_sub_category", 
    "gi_description", 
    "gi_description_de", 
    "gi_description_es", 
    "gi_is_paid_promotion", 
    "gi_brand", 
    "gi_brand_image", 
    "gi_featured_image", 
    "gi_map", 
    "gallery_title", 
    "gallery_title_de", 
    "gallery_title_es", 
    "gallery_images", 
    "au_title", 
    "au_title_de", 
    "au_title_es", 
    "au_description", 
    "au_description_de", 
    "au_description_es", 
    "pdt_product_title", 
    "pdt_product_title_de", 
    "pdt_product_title_es", 
    "pdt_product_description", 
    "pdt_product_description_de", 
    "pdt_product_description_es", 
    "pdt_product_image", 
    "pdt_product_link", 
    "cu_title", 
    "cu_title_de", 
    "cu_title_es", 
    "cu_info", 
    "cu_info_de", 
    "cu_info_es", 
    "cu_city_country", 
    "latitude", 
    "longitude", 
    "cu_email", 
    "cu_website",   
  ];
  if (($open = fopen($path, "r")) !== FALSE) {

    while (($data = fgetcsv($open, 100000, ",")) !== FALSE) {
      $csvData[] = array_combine($array_keys ,$data);
    }

    fclose($open);
    array_shift($csvData);
    combineSimilarRecords($csvData);
  }
  return $csvData;
}

function combineSimilarRecords(&$array){
  $distinctSlugs = array_unique(array_column($array, 'slug'));
  foreach($distinctSlugs as $slug){
    $similarRecords = array_filter($array, function($value) use($slug){
      return $value['slug'] == $slug;
    });
    if(count($similarRecords) > 1){
      $record = [];
      $multiValCols = ["gallery_images", 'pdt_product_title', 'pdt_product_title_de', 'pdt_product_title_es', 'pdt_product_description', 'pdt_product_description_de', 'pdt_product_description_es', 'pdt_product_image', 'pdt_product_link'];
      // create new record
      foreach($similarRecords as $val){
        foreach($val as $key => $value){
          if(in_array($key, $multiValCols)){
            if(!is_array($record[$key])){
              $record[$key] = [$value];
            } else {
              array_push($record[$key], $value);
            }
          } else {
            if(!empty($value)){
              $record[$key] = $value;
            }
          }
        }
      }
      // remove and add records
      foreach(array_keys($similarRecords) as $key){
        array_splice($array, $key, 1);
      }
      array_push($array, $record);
    }
  }
  print_r(($array));
}

<?php
// const choices = [
//   "Main Category" => [
//     "clothing-textile" => "Clothing & Textile",
//     "eat-drink" => "Eat & Drink",
//     "living-working" => "Living & Working",
//     "energy-electronics" => "Energy & Electronics",
//     "wellness-beauty" => "Wellness & Beauty",
//   ],
//   "Sub Category" => [
//     "bio" => "Bio",
//     "veg" => "Vegan",
//     "fair" => "Fair",
//     "rec" => "Recycled",
//     "soc" => "Social",
//   ],
//   [
    
//   ]
// ];

$array = [
  1,2,3,4 
];

array_splice($array, 0, 1);
print_r($array);
