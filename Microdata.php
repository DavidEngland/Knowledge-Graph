<?php

/*
A simple PHP class for playing with Microdata (http://schema.org) by Leonard Challis (http://blog.leonardchallis.com/programming/a-php-class-to-play-with-microdata)
Do with this what you will. I'd be interested in seeing what you have done with it, let me know!
I'd appreciate you leaving this comment here and the link to the original blog-post.
*/

class Microdata
{
  
  public $microdata;
  private $_complete, $_parent, $_friendlyReferences;
  
  /* helper function to aid in walking through recursive microdata */
  private function _reset() {
    $this->_complete = false;
    $this->_parent = null;
    $this->_friendlyReferences = array();
  }
  
  public function __construct($setAdditionalHierarchy = true, $setRecursiveHierarchy = false) {
    
    $this->microdata = array(
      'DataType' => array(
        'Boolean' => array(
          
        ),
        'Date' => array(
          
        ),
        'Number' => array(
          'Float' => array(
            
          ),
          'Integer' => array(
            
          )
        ),
        'Text' => array(
          'URL' => array(
            
          )
        ),
      ),
      'Thing' => array(
      	'name' => '',
      	'url' => '',
      	'image' => '',
      	'description' => '',
      	'CreativeWork' => array(
      		'encodings' => '',
      		'headline' => '',
      		'keywords' => '',
      		'about' => '',
      		'datePublished' => '',
      		'contentRating' => '',
      		'inLanguage' => '',
      		'audio' => '',
      		'video' => '',
      		'genre' => '',
      		'editor' => '',
      		'awards' => '',
      		'publisher' => '',
      		'isFamilyFriendly' => '',
      		'contentLocation' => '',
      		'interactionCount' => '',
      		'aggregateRating' => '',
      		'offers' => '',
      		'reviews' => '',
      		'Article' => array(
      			'articleSection' => '',
      			'articleBody' => '',
      			'BlogPosting' => array(
              
      			),
      			'NewsArticle' => array(
      			  
      			),
      			'ScholarlyArticle' => array(
      			  
      			)
      		),
      		'Blog' => array(
      			'blogPosts' => ''
      		),
      		'Book' => array(
      			'illustrator' => '',
      			'bookEdition' => '',
      			'bookFormat' => '',
      			'numberOfPages' => '',
      			'isbn' => ''
      		),
      		'ItemList' => array(
      			'itemListElement' => ''
      		),
      		'Map' => array(
      		  
      		),
      		'MediaObject' => array(
      			'encodesCreativeWork' => '',
      			'width' => '',
      			'height' => '',
      			'regionsAllowed' => '',
      			'embedURL' => '',
      			'bitrate' => '',
      			'encodingFormat' => '',
      			'playerType' => '',
      			'duration' => '',
      			'expires' => '',
      			'contentURL' => '',
      			'requiresSubscription' => '',
      			'uploadDate' => '',
      			'contentSize' => '',
      			'interactionCount' => '',
      			'offers' => '',
      			'AudioObject' => array(
              
      			),
      			'ImageObject' => array(
      				'thumbnail' => '',
      				'representativeOfPage' => '',
      				'caption' => '',
      				'exifData' => ''
      			),
      			'MusicVideoObject' => array(
              
      			),
      			'VideoObject' => array(
      				'thumbnail' => '',
      				'productionCompany' => '',
      				'caption' => '',
      				'videoQuality' => '',
      				'videoFrameSize' => ''
      			)
      		),
      		'Movie' => array(
      			'duration' => '',
      			'director' => '',
      			'actors' => '',
      			'producer' => '',
      			'trailer' => '',
      			'productionCompany' => '',
      			'musicBy' => ''
      		),
      		'MusicPlaylist' => array(
      			'tracks' => '',
      			'numTracks' => '',
      			'MusicAlbum' => array(
      				'byArtist' => ''
      			)
      		),
      		'MusicRecording' => array(
      			'duration' => '',
      			'byArtist' => '',
      			'inAlbum' => '',
      			'inPlaylist' => ''
      		),
      		'Painting' => array(
      		  
      		),
      		'Photograph' => array(
      		  
      		),
      		'Recipe' => array(
      			'prepTime' => '',
      			'cookTime' => '',
      			'cookingMethod' => '',
      			'totalTime' => '',
      			'nutrition' => '',
      			'ingredients' => '',
      			'recipeInstructions' => '',
      			'recipeYield' => '',
      			'recipeCuisine' => '',
      			'recipeCategory' => ''
      		),
      		'Review' => array(
      			'reviewBody' => '',
      			'itemReviewed' => '',
      			'reviewRating' => ''
      		),
      		'Sculpture' => array(
      		  
      		),
      		'TVEpisode' => array(
      			'director' => '',
      			'actors' => '',
      			'producer' => '',
      			'trailer' => '',
      			'productionCompany' => '',
      			'partOfTVSeries' => '',
      			'partOfSeason' => '',
      			'episodeNumber' => '',
      			'musicBy' => ''
      		),
      		'TVSeason' => array(
      			'trailer' => '',
      			'episodes' => '',
      			'partOfTVSeries' => '',
      			'seasonNumber' => '',
      			'numberOfEpisodes' => '',
      			'startDate' => '',
      			'endDate' => ''
      		),
      		'TVSeries' => array(
      			'director' => '',
      			'actors' => '',
      			'producer' => '',
      			'trailer' => '',
      			'productionCompany' => '',
      			'episodes' => '',
      			'seasons' => '',
      			'numberOfEpisodes' => '',
      			'musicBy' => '',
      			'startDate' => '',
      			'endDate' => ''
      		),
      		'WebPage' => array(
      			'breadcrumb' => '',
      			'mainContentOfPage' => '',
      			'primaryImageOfPage' => '',
      			'isPartOf' => '',
      			'significantLinks' => '',
      			'AboutPage' => array(
      		    
      			),
      			'CheckoutPage' => array(
      			  
      			),
      			'CollectionPage' => array(
      				'ImageGallery' => array(
      			    
      				),
      				'VideoGallery' => array(
      				  
      				)
      			),
      			'ContactPage' => array(
              
      			),
      			'ItemPage' => array(
              
      			),
      			'ProfilePage' => array(
              
      			),
      			'SearchResultsPage' => array(
              
      			)
      		),
      		'WebPageElement' => array(
      			'SiteNavigationElement' => array(
              
      			),
      			'Table' => array(
              
      			),
      			'WPAdBlock' => array(
              
      			),
      			'WPFooter' => array(
              
      			),
      			'WPHeader' => array(
              
      			),
      			'WPSideBar' => array(
              
      			)
      		)
      	),
      	'Event' => array(
      		'duration' => '',
      		'location' => '',
      		'startDate' => '',
      		'endDate' => '',
      		'performers' => '',
      		'attendees' => '',
      		'subEvents' => '',
      		'superEvent' => '',
      		'offers' => '',
      		'BusinessEvent' => array(
            
      		),
      		'ChildrensEvent' => array(
            
      		),
      		'ComedyEvent' => array(
            
      		),
      		'DanceEvent' => array(
            
      		),
      		'EducationEvent' => array(
            
      		),
      		'Festival' => array(
            
      		),
      		'FoodEvent' => array(
            
      		),
      		'LiteraryEvent' => array(
            
      		),
      		'MusicEvent' => array(
            
      		),
      		'SaleEvent' => array(
            
      		),
      		'SocialEvent' => array(
            
      		),
      		'SportsEvent' => array(
            
      		),
      		'TheaterEvent' => array(
            
      		),
      		'UserInteraction' => array(
      			'UserBlocks' => array(
              
      			),
      			'UserCheckins' => array(
              
      			),
      			'UserComments' => array(
              
      			),
      			'UserDownloads' => array(
              
      			),
      			'UserLikes' => array(
              
      			),
      			'UserPageVisits' => array(
              
      			),
      			'UserPlays' => array(
              
      			),
      			'UserPlusOnes' => array(
              
      			),
      			'UserTweets' => array(
              
      			)
      		),
      		'VisualArtsEvent' => array(
             
      		)
      	),
      	'Intangible' => array(
      		'Enumeration' => array(
      			'BookFormatType' => array(
              'EBook',
      	      'Hardcover',
      	      'Paperback'
      			),
      			'ItemAvailability' => array(
      	      'Discontinued',
      	      'InStock',
      	      'InStoreOnly',
      	      'OnlineOnly',
      	      'OutOfStock',
      	      'PreOrder' 
      			),
      			'OfferItemCondition' => array(
              'DamagedCondition',
              'NewCondition',
              'RefurbishedCondition',
              'UsedCondition' 
      			)
      		),
      		'Language' => array(
            
      		),
      		'Offer' => array(
      			'aggregateRating' => '',
      			'reviews' => '',
      			'price' => '',
      			'priceCurrency' => '',
      			'priceValidUntil' => '',
      			'seller' => '',
      			'itemCondition' => '',
      			'availability' => '',
      			'itemOffered' => '',
      			'AggregateOffer' => array(
      				'lowPrice' => '',
      				'highPrice' => '',
      				'offerCount' => ''
      			),
      		),
      		'Quantity' => array(
      			'Distance' => array(
      				
      			),
      			'Duration' => array(
      				
      			),
      			'Energy' => array(
      				
      			),
      			'Mass' => array(
      				
      			)
      		),
      		'Rating' => array(
      			'bestRating' => '',
      			'worstRating' => '',
      			'ratingValue' => '',
      			'AggregateRating' => array(
      				'itemReviewed' => '',
      				'ratingCount' => '',
      				'reviewCount' => ''
      			)
      		),
      		'StructuredValue' => array(
      			'ContactPoint' => array(
      				'email' => '',
      				'telephone' => '',
      				'faxNumber' => '',
      				'contactType' => '',
      				'PostalAddress' => array(
      					'streetAddress' => '',
      					'addressLocality' => '',
      					'addressRegion' => '',
      					'postalCode' => '',
      					'postOfficeBoxNumber' => '',
                'addressCountry' => ''
      				)
      			),
      			'GeoCoordinates' => array(
      				'latitude' => '',
      				'longitude' => '',
      				'elevation' => ''
      			),
      			'NutritionInformation' => array(
      				'servingSize' => '',
      				'calories' => '',
      				'fatContent' => '',
      				'saturatedFatContent' => '',
      				'unsaturatedFatContent' => '',
      			  'transFatContent' => '',
      				'carbohydrateContent' => '',
      				'sugarContent' => '', 'fiberContent' => '',
      				'proteinContent' => '',
      				'cholesterolContent' => '',
      				'sodiumContent' => ''
      			)
      		)
      	),
      	'Organization' => array(
      		'interactionCount' => '',
      		'location' => '',
      		'employees' => '',
      		'members' => '',
      		'foundingDate' => '',
      		'founders' => '',
      		'contactPoints' => '',
      		'email' => '',
      		'events' => '',
      		'address' => '',
      		'telephone' => '',
      		'faxNumber' => '',
      		'aggregateRating' => '',
      		'reviews' => '',
      		'Corporation' => array(
      	    
      	  ),
      		'EducationalOrganization' => array(
      	    'alumni' => array(
      	      
      	    ),
      			'CollegeOrUniversity' => array(
      	      
      	    ),
      			'ElementarySchool' => array(
      	      
      	    ),
      			'HighSchool' => array(
      	      
      	    ),
      			'MiddleSchool' => array(
      	      
      	    ),
      			'Preschool' => array(
      	      
      	    ),
      			'School' => array(
      	      
      	    )
      	  ),
      		'GovernmentOrganization' => array(
            
      		),
      		'LocalBusiness' => array(
      			'branchOf' => '',
      			'openingHours' => '',
      			'paymentAccepted' => '',
      			'currenciesAccepted' => '',
      			'priceRange' => '',
      			'AnimalShelter' => array(
      		    
      		  ),
      			'AutomotiveBusiness' => array(
      				'AutoBodyShop' => array(
      		      
      		    ),
      				'AutoDealer' => array(
      		      
      		    ),
      				'AutoPartsStore' => array(
      		      
      		    ),
      				'AutoRental' => array(
      		      
      		    ),
      				'AutoRepair' => array(
      		      
      		    ),
      				'AutoWash' => array(
      		      
      		    ),
      				'GasStation' => array(
      		      
      		    ),
      				'MotorcycleDealer' => array(
      		      
      		    ),
      				'MotorcycleRepair' => array(
      		      
      		    )
      		  ),
      			'ChildCare' => array(
      		    
      		  ),
      			'DryCleaningOrLaundry' => array(
      		    
      		  ),
      			'EmergencyService' => array(
      				'FireStation' => array(
      		      
      		    ),
      				'Hospital' => null,
      				'PoliceStation' => array(
      		      
      		    )
      		  ),
      			'EmploymentAgency' => array(
      		    
      		  ),
      			'EntertainmentBusiness' => array(
      				'AdultEntertainment' => array(
      		      
      		    ),
      				'AmusementPark' => array(
      		      
      		    ),
      				'ArtGallery' => array(
      		      
      		    ),
      				'Casino' => array(
      		      
      		    ),
      				'ComedyClub' => array(
      		      
      		    ),
      				'MovieTheater' => array(
      		      
      		    ),
      				'NightClub' => array(
      		      
      		    )
      		  ),
      			'FinancialService' => array(
      				'AccountingService' => array(
      		      
      		    ),
      				'AutomatedTeller' => array(
      		      
      		    ),
      				'BankOrCreditUnion' => array(
      		      
      		    ),
      				'InsuranceAgency' => array(
      		      
      		    )
      		  ),
      			'FoodEstablishment' => array(
      				'menu' => '',
      				'acceptsReservations' => '',
      				'servesCuisine' => '',
      				'Bakery' => array(
      		      
      		    ),
      				'BarOrPub' => array(
      		      
      		    ),
      				'Brewery' => array(
      		      
      		    ),
      				'CafeOrCoffeeShop' => array(
      		      
      		    ),
      				'FastFoodRestaurant' => array(
      		      
      		    ),
      				'IceCreamShop' => array(
      		      
      		    ),
      				'Restaurant' => array(
      		      
      		    ),
      				'Winery' => array(
      		      
      		    )
      		  ),
      			'GovernmentOffice' => array(
      				'PostOffice' => array(
      		      
      		    )
      		  ),
      			'HealthAndBeautyBusiness' => array(
      				'BeautySalon' => array(
      		      
      		    ),
      				'DaySpa' => array(
      		      
      		    ),
      				'HairSalon' => array(
      		      
      		    ),
      				'HealthClub' => array(
      		      
      		    ),
      				'NailSalon' => array(
      		      
      		    ),
      				'TattooParlor' => array(
      		      
      		    )
      		  ),
      			'HomeAndConstructionBusiness' => array(
      				'Electrician' => array(
      		      
      		    ),
      				'GeneralContractor' => array(
      		      
      		    ),
      				'HVACBusiness' => array(
      		      
      		    ),
      				'HousePainter' => array(
      		      
      		    ),
      				'Locksmith' => array(
      		      
      		    ),
      				'MovingCompany' => array(
      		      
      		    ),
      				'Plumber' => array(
      		      
      		    ),
      				'RoofingContractor' => array(
      		      
      		    )
      		  ),
      			'InternetCafe' => array(
      		    
      		  ),
      			'Library' => array(
      		    
      		  ),
      			'LodgingBusiness' => array(
      				'BedAndBreakfast' => array(
      		      
      		    ),
      				'Hostel' => array(
      		      
      		    ),
      				'Hotel' => array(
      		      
      		    ),
      				'Motel' => array(
      		      
      		    )
      		  ),
      			'MedicalOrganization' => array(
      				'Dentist' => array(
      		      
      		    ),
      				'Hospital' => array(
      		      
      		    ),
      				'MedicalClinic' => array(
      		      
      		    ),
      				'Optician' => array(
      		      
      		    ),
      				'Pharmacy' => array(
      		      
      		    ),
      				'Physician' => array(
      		      
      		    ),
      				'VeterinaryCare' => array(
      		      
      		    )
      		  ),
      			'ProfessionalService' => array(
      				'AccountingService' => null,
      				'Attorney' => array(
      		      
      		    ),
      				'Dentist' => null,
      				'Electrician' => null,
      				'GeneralContractor' => null,
      				'HousePainter' => null,
      				'Locksmith' => null,
      				'Notary' => array(
      		      
      		    ),
      				'Plumber' => null,
      				'RoofingContractor' => null
      		  ),
      			'RadioStation' => array(
      		    
      		  ),
      			'RealEstateAgent' => array(
      		    
      		  ),
      			'RecyclingCenter' => array(
      		    
      		  ),
      			'SelfStorage' => array(
      		    
      		  ),
      			'ShoppingCenter' => array(
      		    
      		  ),
      			'SportsActivityLocation' => array(
      				'BowlingAlley' => array(
      		      
      		    ),
      				'ExerciseGym' => array(
      		      
      		    ),
      				'GolfCourse' => array(
      		      
      		    ),
      				'HealthClub' => null,
      				'PublicSwimmingPool' => array(
      		      
      		    ),
      				'SkiResort' => array(
      		      
      		    ),
      				'SportsClub' => array(
      		      
      		    ),
      				'StadiumOrArena' => array(
      		      
      		    ),
      				'TennisComplex' => array(
      		      
      		    ),
      		  ),
      			'Store' => array(
      				'AutoPartsStore' => null,
      				'BikeStore' => array(
      		      
      		    ),
      				'BookStore' => array(
      		      
      		    ),
      				'ClothingStore' => array(
      		      
      		    ),
      				'ComputerStore' => array(
      		      
      		    ),
      				'ConvenienceStore' => array(
      		      
      		    ),
      				'DepartmentStore' => array(
      		      
      		    ),
      				'ElectronicsStore' => array(
      		      
      		    ),
      				'Florist' => array(
      		      
      		    ),
      				'FurnitureStore' => array(
      		      
      		    ),
      				'GardenStore' => array(
      		      
      		    ),
      				'GroceryStore' => array(
      		      
      		    ),
      				'HardwareStore' => array(
      		      
      		    ),
      				'HobbyShop' => array(
      		      
      		    ),
      				'HomeGoodsStore' => array(
      		      
      		    ),
      				'JewelryStore' => array(
      		      
      		    ),
      				'LiquorStore' => array(
      		      
      		    ),
      				'MensClothingStore' => array(
      		      
      		    ),
      				'MobilePhoneStore' => array(
      		      
      		    ),
      				'MovieRentalStore' => array(
      		      
      		    ),
      				'MusicStore' => array(
      		      
      		    ),
      				'OfficeEquipmentStore' => array(
      		      
      		    ),
      				'OutletStore' => array(
      		      
      		    ),
      				'PawnShop' => array(
      		      
      		    ),
      				'PetStore' => array(
      		      
      		    ),
      				'ShoeStore' => array(
      		      
      		    ),
      				'SportingGoodsStore' => array(
      		      
      		    ),
      				'TireShop' => array(
      		      
      		    ),
      				'ToyStore' => array(
      		      
      		    ),
      				'WholesaleStore' => array(
      		      
      		    )
      		  ),
      			'TelevisionStation' => array(
      		    
      		  ),
      			'TouristInformationCenter' => array(
      		    
      		  ),
      			'TravelAgency' => array(
      		    
      		  )
      		),
      		'NGO' => array(
      		
      		),
      		'PerformingGroup' => array(
      			'DanceGroup' => array(
      		    
      		  ),
      			'MusicGroup' => array(
      				'musicGroupMember' => '',
      		  	'tracks' => '',
      		  	'albums' => ''
      		  ),
      			'TheaterGroup' => array(
      		     
      		  )
      		),
      		'SportsTeam' => array(
      		
      		)
      	),
      	'Person' => array(
      		'awards' => '',
      		'interactionCount' => '',
      		'jobTitle' => '',
      		'affiliation' => '',
      		'worksFor' => '',
      		'alumniOf' => '',
      		'memberOf' => '',
      		'contactPoints' => '',
      		'workLocation' => '',
      		'homeLocation' => '',
      		'gender' => '',
      		'email' => '',
      		'birthDate' => '',
      		'deathDate' => '',
      		'nationality' => '',
      		'relatedTo' => '',
      		'spouse' => '',
      		'parents' => '',
      		'children' => '',
      		'siblings' => '',
      		'colleagues' => '',
      		'knows' => '',
      		'performerIn' => '',
      		'follows' => '',
      		'address' => '',
      		'telephone' => '',
      		'faxNumber' => ''
      	),
      	'Place' => array(
      		'interactionCount' => '',
      		'containedIn' => '',
      		'photos' => '',
      		'geo' => '',
      		'events' => '',
      		'maps' => '',
      		'address' => '',
      		'telephone' => '',
      		'faxNumber' => '',
      		'aggregateRating' => '',
      		'reviews' => '',
      		'AdministrativeArea' => array(
      			'City' => array(
      	      
      	    ),
      			'Country' => array(
      	      
      	    ),
      			'State' => array(
      	      
      	    )
      	  ),
      		'CivicStructure' => array(
      	    'openingHours' => '',
      			'Airport' => array(
      	      
      	    ),
      			'Aquarium' => array(
      	      
      	    ),
      			'Beach' => array(
      	      
      	    ),
      			'BusStation' => array(
      	      
      	    ),
      			'BusStop' => array(
      	      
      	    ),
      			'Campground' => array(
      	      
      	    ),
      			'Cemetery' => array(
      	      
      	    ),
      			'Crematorium' => array(
      	      
      	    ),
      			'EventVenue' => array(
      	      
      	    ),
      			'FireStation' => array(
      	      
      	    ),
      			'GovernmentBuilding' => array(
      				'CityHall' => array(
      	        
      	      ),
      				'Courthouse' => array(
      	        
      	      ),
      				'DefenceEstablishment' => array(
      	        
      	      ),
      				'Embassy' => array(
      	        
      	      ),
      				'LegislativeBuilding' => array(
      	        
      	      )
      	    ),
      			'Hospital' => null,
      			'MovieTheater' => array(
      	      
      	    ),
      			'Museum' => array(
      	      
      	    ),
      			'MusicVenue' => array(
      	      
      	    ),
      			'Park' => array(
      	      
      	    ),
      			'ParkingFacility' => array(
      	      
      	    ),
      			'PerformingArtsTheater' => array(
      	      
      	    ),
      			'PlaceOfWorship' => array(
      				'BuddhistTemple' => array(
      	        
      	      ),
      				'CatholicChurch' => array(
      	        
      	      ),
      				'Church' => array(
      	        
      	      ),
      				'HinduTemple' => array(
      	        
      	      ),
      				'Mosque' => array(
      	        
      	      ),
      				'Synagogue' => array(
      	        
      	      )
      	    ),
      			'Playground' => array(
      	      
      	    ),
      			'PoliceStation' => null,
      			'RVPark' => array(
      	      
      	    ),
      			'StadiumOrArena' => null,
      			'SubwayStation' => array(
      	      
      	    ),
      			'TaxiStand' => array(
      	      
      	    ),
      			'TrainStation' => array(
      	      
      	    ),
      			'Zoo' => array(
      	      
      	    ),
      		'Landform' => array(
      			'BodyOfWater' => array(
      	        
      	      ),
      				'Canal' => array(
      	        
      	      ),
      				'LakeBodyOfWater' => array(
      	        
      	      ),
      				'OceanBodyOfWater' => array(
      	        
      	      ),
      				'Pond' => array(
      	        
      	      ),
      				'Reservoir' => array(
      	        
      	      ),
      				'RiverBodyOfWater' => array(
      	        
      	      ),
      				'SeaBodyOfWater' => array(
      	        
      	      ),
      				'Waterfall' => array(
      	        
      	      )
      	    ),
      			'Continent' => array(
      	      
      	    ),
      			'Mountain' => array(
      	      
      	    ),
      			'Volcano' => array(
      	      
      	    )
      	  ),
      		'LandmarksOrHistoricalBuildings' => array(
            
      	  ),
      		'LocalBusiness' => null,
      		'Residence' => array(
      			'ApartmentComplex' => array(
      	      
      	    ),
      			'GatedResidenceCommunity' => array(
      	      
      	    ),
      			'SingleFamilyResidence' => array(
      	      
      	    )
      	  ),
      		'TouristAttraction' => array(
      	    
      	  )
      	),
      	'Product' => array(
      		'brand' => '',
      		'model' => '',
      		'aggregateRating' => '',
      		'productID' => '',
      		'manufacturer' => '',
      		'offers' => '',
      		'reviews' => ''
      	)
      )
    );
    
    /* setup items with multiple parents */
    $setAdditionalHierarchy && $this->setAdditionalHierarchy();
    /* setup recursive references */
    $setRecursiveHierarchy && $this->setRecursiveHierarchy();
  }
  
  /* set up items to have additional hierarchy */ 
  public function setAdditionalHierarchy() {
    /* items with multiple parents */
    $this->microdata['Thing']['Place']['LocalBusiness'] = &$this->microdata['Thing']['Organization']['LocalBusiness'];
    $this->microdata['Thing']['Organization']['LocalBusiness']['EmergencyService']['Hospital'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['MedicalOrganization']['Hospital']; 
    $this->microdata['Thing']['Place']['CivicStructure']['Hospital'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['MedicalOrganization']['Hospital'];
    $this->microdata['Thing']['Organization']['LocalBusiness']['ProfessionalService']['AccountingService'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['FinancialService']['AccountingService'];
    $this->microdata['Thing']['Organization']['LocalBusiness']['ProfessionalService']['Dentist'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['MedicalOrganization']['Dentist'];  
    $this->microdata['Thing']['Organization']['LocalBusiness']['ProfessionalService']['Electrician'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['HomeAndConstructionBusiness']['Electrician'];
    $this->microdata['Thing']['Organization']['LocalBusiness']['ProfessionalService']['GeneralContractor'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['HomeAndConstructionBusiness']['GeneralContractor']; 
    $this->microdata['Thing']['Organization']['LocalBusiness']['ProfessionalService']['HousePainter'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['HomeAndConstructionBusiness']['HousePainter'];
    $this->microdata['Thing']['Organization']['LocalBusiness']['ProfessionalService']['Locksmith'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['HomeAndConstructionBusiness']['Locksmith'];
    $this->microdata['Thing']['Organization']['LocalBusiness']['ProfessionalService']['Plumber'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['HomeAndConstructionBusiness']['Plumber'];
    $this->microdata['Thing']['Organization']['LocalBusiness']['ProfessionalService']['RoofingContractor'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['HomeAndConstructionBusiness']['RoofingContractor'];
    $this->microdata['Thing']['Organization']['LocalBusiness']['SportsActivityLocation']['HealthClub'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['HealthAndBeautyBusiness']['HealthClub'];
    $this->microdata['Thing']['Organization']['LocalBusiness']['Store']['AutoPartsStore'] = &$mirodata['Thing']['Organization']['LocalBusiness']['AutomotiveBusiness']['AutoPartsStore'];
    $this->microdata['Thing']['Organization']['Place']['CivicStructure']['PoliceStation'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['EmergencyService']['PoliceStation'];
    $this->microdata['Thing']['Place']['CivicStructure']['StadiumOrArena'] = &$this->microdata['Thing']['Organization']['LocalBusiness']['SportsActivityLocation']['StadiumOrArena'];
  }
  
  /* apply recursive hierarchy - warning, be careful with this! very easy to get stuck in endless loops */
  public function setRecursiveHierarchy() {
    
    /* set up all the datatypes */
    $this->microdata['Thing']['description'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['images'] = &$this->microdata['DataType']['Text']['URL'];
    $this->microdata['Thing']['name'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['url'] = &$this->microdata['DataType']['Text']['URL'];
    $this->microdata['Thing']['CreativeWork']['about'] = &$this->microdata['Thing'];
    
    /*  -> Thing */
    $this->microdata['Thing']['description'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['image'] = &$this->microdata['DataType']['Text']['URL'];
    $this->microdata['Thing']['name'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['url'] = &$this->microdata['DataType']['Text']['URL'];
    
    /*  -> Thing -> CreativeWork */
    $this->microdata['Thing']['CreativeWork']['about'] = &$this->microdata['Thing'];
    $this->microdata['Thing']['CreativeWork']['aggregateRating'] = &$this->microdata['Thing']['Intangible']['Rating']['AggregateRating'];
    $this->microdata['Thing']['CreativeWork']['audio'] = &$this->microdata['Thing']['CreativeWork']['MediaObject']['AudioObject'];
    $this->microdata['Thing']['CreativeWork']['author'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['awards'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['contentLocation'] = &$this->microdata['Thing']['Place'];
    $this->microdata['Thing']['CreativeWork']['contentRating'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['datePublished'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['CreativeWork']['editor'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['encodings'] = &$this->microdata['Thing']['CreativeWork']['MediaObject'];
    $this->microdata['Thing']['CreativeWork']['genre'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['headline'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['inLanguage'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['interactionCount'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['isFamilyFriendly'] = &$this->microdata['DataType']['Boolean'];
    $this->microdata['Thing']['CreativeWork']['keywords'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['offers'] = &$this->microdata['Thing']['Intangible']['Offer'];
    $this->microdata['Thing']['CreativeWork']['publisher'] = &$this->microdata['Thing']['Organization'];
    $this->microdata['Thing']['CreativeWork']['reviews'] = &$this->microdata['Thing']['CreativeWork']['Review'];
    $this->microdata['Thing']['CreativeWork']['video'] = &$this->microdata['Thing']['CreativeWork']['MediaObject']['VideoObject'];
    
    
    /*  -> Thing -> CreativeWork -> Article */
    $this->microdata['Thing']['CreativeWork']['Article']['articleBody'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['Article']['articleSection'] = &$this->microdata['DataType']['Text'];
    
    
    /*  -> Thing -> CreativeWork -> Blog */
    $this->microdata['Thing']['CreativeWork']['Blog']['blogPosts'] = &$this->microdata['Thing']['CreativeWork']['Article']['BlogPosting'];
    
    
    /*  -> Thing -> CreativeWork -> Book */
    $this->microdata['Thing']['CreativeWork']['Book']['bookEdition'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['Book']['bookFormat'] = &$this->microdata['Thing']['Intangible']['Enumeration']['BookFormatType'];
    $this->microdata['Thing']['CreativeWork']['Book']['illustrator'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['Book']['isbn'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['Book']['numberOfPages'] = &$this->microdata['DataType']['Number']['Integer'];
    
    
    /*  -> Thing -> CreativeWork -> ItemList */
    $this->microdata['Thing']['CreativeWork']['ItemList']['itemListElement'] = &$this->microdata['DataType']['Text'];
    
    
    /*  -> Thing -> CreativeWork -> MediaObject */
    $this->microdata['Thing']['CreativeWork']['MediaObject']['bitrate'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['contentSize'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['contentURL'] = &$this->microdata['DataType']['Text']['URL'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['duration'] = &$this->microdata['Thing']['Intangible']['Quantity']['Duration'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['embedURL'] = &$this->microdata['DataType']['Text']['URL'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['encodesCreativeWork'] = &$this->microdata['Thing']['CreativeWork'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['encodingFormat'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['expires'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['height'] = &$this->microdata['Thing']['Intangible']['Quantity']['Distance'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['playerType'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['regionsAllowed'] = &$this->microdata['Thing']['Place'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['requiresSubscription'] = &$this->microdata['DataType']['Boolean'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['uploadDate'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['width'] = &$this->microdata['Thing']['Intangible']['Quantity']['Distance'];
    
    
    /*  -> Thing -> CreativeWork -> MediaObject -> ImageObject */
    $this->microdata['Thing']['CreativeWork']['MediaObject']['ImageObject']['caption'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['ImageObject']['exifData'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['ImageObject']['representativeOfPage'] = &$this->microdata['DataType']['Boolean'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['ImageObject']['thumbnail'] = &$this->microdata['Thing']['CreativeWork']['MediaObject']['ImageObject'];
    
    
    /*  -> Thing -> CreativeWork -> MediaObject -> VideoObject */
    $this->microdata['Thing']['CreativeWork']['MediaObject']['VideoObject']['caption'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['VideoObject']['productionCompany'] = &$this->microdata['Thing']['Organization'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['VideoObject']['thumbnail'] = &$this->microdata['Thing']['CreativeWork']['MediaObject']['ImageObject'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['VideoObject']['videoFrameSize'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['MediaObject']['VideoObject']['videoQuality'] = &$this->microdata['DataType']['Text'];
    
    
    /*  -> Thing -> CreativeWork -> Movie */
    $this->microdata['Thing']['CreativeWork']['Movie']['actors'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['Movie']['director'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['Movie']['duration'] = &$this->microdata['Thing']['Intangible']['Quantity']['Duration'];
    $this->microdata['Thing']['CreativeWork']['Movie']['musicBy'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['Movie']['producer'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['Movie']['productionCompany'] = &$this->microdata['Thing']['Organization'];
    $this->microdata['Thing']['CreativeWork']['Movie']['trailer'] = &$this->microdata['Thing']['CreativeWork']['MediaObject']['VideoObject'];
    
    
    /*  -> Thing -> CreativeWork -> MusicPlaylist */
    $this->microdata['Thing']['CreativeWork']['MusicPlaylist']['numTracks'] = &$this->microdata['DataType']['Number']['Integer'];
    $this->microdata['Thing']['CreativeWork']['MusicPlaylist']['tracks'] = &$this->microdata['Thing']['CreativeWork']['MusicRecording'];
    
    
    /*  -> Thing -> CreativeWork -> MusicPlaylist -> MusicAlbum */
    $this->microdata['Thing']['CreativeWork']['MusicPlaylist']['MusicAlbum']['byArtist'] = &$this->microdata['Thing']['Organization']['PerformingGroup']['MusicGroup'];
    
    
    /*  -> Thing -> CreativeWork -> MusicRecording */
    $this->microdata['Thing']['CreativeWork']['MusicRecording']['byArtist'] = &$this->microdata['Thing']['Organization']['PerformingGroup']['MusicGroup'];
    $this->microdata['Thing']['CreativeWork']['MusicRecording']['duration'] = &$this->microdata['Thing']['Intangible']['Quantity']['Duration'];
    $this->microdata['Thing']['CreativeWork']['MusicRecording']['inAlbum'] = &$this->microdata['Thing']['CreativeWork']['MusicPlaylist']['MusicAlbum'];
    $this->microdata['Thing']['CreativeWork']['MusicRecording']['inPlaylist'] = &$this->microdata['Thing']['CreativeWork']['MusicPlaylist'];
    
    
    /*  -> Thing -> CreativeWork -> Recipe */
    $this->microdata['Thing']['CreativeWork']['Recipe']['cookTime'] = &$this->microdata['Thing']['Intangible']['Quantity']['Duration'];
    $this->microdata['Thing']['CreativeWork']['Recipe']['cookingMethod'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['Recipe']['ingredients'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['Recipe']['nutrition'] = &$this->microdata['Thing']['Intangible']['StructuredValue']['NutritionInformation'];
    $this->microdata['Thing']['CreativeWork']['Recipe']['prepTime'] = &$this->microdata['Thing']['Intangible']['Quantity']['Duration'];
    $this->microdata['Thing']['CreativeWork']['Recipe']['recipeCategory'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['Recipe']['recipeCuisine'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['Recipe']['recipeInstructions'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['Recipe']['recipeYield'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['Recipe']['totalTime'] = &$this->microdata['Thing']['Intangible']['Quantity']['Duration'];
    
    
    /*  -> Thing -> CreativeWork -> Review */
    $this->microdata['Thing']['CreativeWork']['Review']['itemReviewed'] = &$this->microdata['Thing'];
    $this->microdata['Thing']['CreativeWork']['Review']['reviewBody'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['Review']['reviewRating'] = &$this->microdata['Thing']['Intangible']['Rating'];
    
    
    /*  -> Thing -> CreativeWork -> TVEpisode */
    $this->microdata['Thing']['CreativeWork']['TVEpisode']['actors'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['TVEpisode']['director'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['TVEpisode']['episodeNumber'] = &$this->microdata['DataType']['Number'];
    $this->microdata['Thing']['CreativeWork']['TVEpisode']['musicBy'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['TVEpisode']['partOfSeason'] = &$this->microdata['TVSeason'];
    $this->microdata['Thing']['CreativeWork']['TVEpisode']['partOfTVSeries'] = &$this->microdata['TVSeries'];
    $this->microdata['Thing']['CreativeWork']['TVEpisode']['producer'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['TVEpisode']['productionCompany'] = &$this->microdata['Thing']['Organization'];
    $this->microdata['Thing']['CreativeWork']['TVEpisode']['trailer'] = &$this->microdata['Thing']['CreativeWork']['MediaObject']['VideoObject'];
    
    
    /*  -> Thing -> CreativeWork -> TVSeason */
    $this->microdata['Thing']['CreativeWork']['TVSeason']['endDate'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['CreativeWork']['TVSeason']['episodes'] = &$this->microdata['TVEpisode'];
    $this->microdata['Thing']['CreativeWork']['TVSeason']['numberOfEpisodes'] = &$this->microdata['DataType']['Number'];
    $this->microdata['Thing']['CreativeWork']['TVSeason']['partOfTVSeries'] = &$this->microdata['TVSeries'];
    $this->microdata['Thing']['CreativeWork']['TVSeason']['seasonNumber'] = &$this->microdata['DataType']['Number']['Integer'];
    $this->microdata['Thing']['CreativeWork']['TVSeason']['startDate'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['CreativeWork']['TVSeason']['trailer'] = &$this->microdata['Thing']['CreativeWork']['MediaObject']['VideoObject'];
    
    
    /*  -> Thing -> CreativeWork -> TVSeries */
    $this->microdata['Thing']['CreativeWork']['TVSeries']['actors'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['TVSeries']['director'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['TVSeries']['endDate'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['CreativeWork']['TVSeries']['episodes'] = &$this->microdata['TVEpisode'];
    $this->microdata['Thing']['CreativeWork']['TVSeries']['musicBy'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['TVSeries']['numberOfEpisodes'] = &$this->microdata['DataType']['Number'];
    $this->microdata['Thing']['CreativeWork']['TVSeries']['producer'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['CreativeWork']['TVSeries']['productionCompany'] = &$this->microdata['Thing']['Organization'];
    $this->microdata['Thing']['CreativeWork']['TVSeries']['seasons'] = &$this->microdata['TVSeason'];
    $this->microdata['Thing']['CreativeWork']['TVSeries']['startDate'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['CreativeWork']['TVSeries']['trailer'] = &$this->microdata['Thing']['CreativeWork']['MediaObject']['VideoObject'];
    
    
    /*  -> Thing -> CreativeWork -> WebPage */
    $this->microdata['Thing']['CreativeWork']['WebPage']['breadcrumb'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['CreativeWork']['WebPage']['isPartOf'] = &$this->microdata['CollectionPage'];
    $this->microdata['Thing']['CreativeWork']['WebPage']['mainContentOfPage'] = &$this->microdata['WebPageElement'];
    $this->microdata['Thing']['CreativeWork']['WebPage']['primaryImageOfPage'] = &$this->microdata['Thing']['CreativeWork']['MediaObject']['ImageObject'];
    $this->microdata['Thing']['CreativeWork']['WebPage']['significantLinks'] = &$this->microdata['DataType']['Text']['URL'];
    
    
    /*  -> Thing -> Event */
    $this->microdata['Thing']['Event']['attendees'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Event']['duration'] = &$this->microdata['Thing']['Intangible']['Quantity']['Duration'];
    $this->microdata['Thing']['Event']['endDate'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['Event']['location'] = &$this->microdata['Thing']['Place'];
    $this->microdata['Thing']['Event']['offers'] = &$this->microdata['Thing']['Intangible']['Offer'];
    $this->microdata['Thing']['Event']['performers'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Event']['startDate'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['Event']['subEvents'] = &$this->microdata['Thing']['Event'];
    $this->microdata['Thing']['Event']['superEvent'] = &$this->microdata['Thing']['Event'];
    
    
    /*  -> Thing -> Offer */
    $this->microdata['Thing']['Offer']['aggregateRating'] = &$this->microdata['Thing']['Intangible']['Rating']['AggregateRating'];
    $this->microdata['Thing']['Offer']['availability'] = &$this->microdata['ItemAvailability'];
    $this->microdata['Thing']['Offer']['itemCondition'] = &$this->microdata['OfferItemCondition'];
    $this->microdata['Thing']['Offer']['itemOffered'] = &$this->microdata['Product'];
    $this->microdata['Thing']['Offer']['price'] = array('*mul' => array(&$this->microdata['DataType']['Number'], &$this->microdata['DataType']['Text']));
    $this->microdata['Thing']['Offer']['priceCurrency'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Offer']['priceValidUntil'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['Offer']['reviews'] = &$this->microdata['Thing']['CreativeWork']['Review'];
    $this->microdata['Thing']['Offer']['seller'] = &$this->microdata['Thing']['Organization'];
    
    
    /*  -> Thing -> Offer -> AggregateOffer */
    $this->microdata['Thing']['Offer']['AggregateOffer']['highPrice'] = array('*mul' => array(&$this->microdata['DataType']['Number'], &$this->microdata['DataType']['Text']));
    $this->microdata['Thing']['Offer']['AggregateOffer']['lowPrice'] = array('*mul' => array(&$this->microdata['DataType']['Number'], &$this->microdata['DataType']['Text']));
    $this->microdata['Thing']['Offer']['AggregateOffer']['offerCount'] = &$this->microdata['DataType']['Number']['Integer'];
    
    
    /*  -> Thing -> Rating */
    $this->microdata['Thing']['Rating']['bestRating'] = array('*mul' => array(&$this->microdata['DataType']['Number'], &$this->microdata['DataType']['Text']));
    $this->microdata['Thing']['Rating']['ratingValue'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Rating']['worstRating'] = array('*mul' => array(&$this->microdata['DataType']['Number'], &$this->microdata['DataType']['Text']));
    
    
    /*  -> Thing -> Rating -> AggregateRating */
    $this->microdata['Thing']['Rating']['AggregateRating']['itemReviewed'] = &$this->microdata['Thing'];
    $this->microdata['Thing']['Rating']['AggregateRating']['ratingCount'] = &$this->microdata['DataType']['Number'];
    $this->microdata['Thing']['Rating']['AggregateRating']['reviewCount'] = &$this->microdata['DataType']['Number'];
    
    
    /*  -> Thing -> ContactPoint */
    $this->microdata['Thing']['ContactPoint']['contactType'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['ContactPoint']['email'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['ContactPoint']['faxNumber'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['ContactPoint']['telephone'] = &$this->microdata['DataType']['Text'];
    
    
    /*  -> Thing -> ContactPoint -> PostalAddress */
    $this->microdata['Thing']['ContactPoint']['PostalAddress']['addressCountry'] = &$this->microdata['Country'];
    $this->microdata['Thing']['ContactPoint']['PostalAddress']['addressLocality'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['ContactPoint']['PostalAddress']['addressRegion'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['ContactPoint']['PostalAddress']['postOfficeBoxNumber'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['ContactPoint']['PostalAddress']['postalCode'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['ContactPoint']['PostalAddress']['streetAddress'] = &$this->microdata['DataType']['Text'];
    
    
    /*  -> Thing -> GeoCoordinates */
    $this->microdata['Thing']['GeoCoordinates']['elevation'] = array('*mul' => array(&$this->microdata['DataType']['Number'], &$this->microdata['DataType']['Text']));
    $this->microdata['Thing']['GeoCoordinates']['latitude'] = array('*mul' => array(&$this->microdata['DataType']['Number'], &$this->microdata['DataType']['Text']));
    $this->microdata['Thing']['GeoCoordinates']['longitude'] = array('*mul' => array(&$this->microdata['DataType']['Number'], &$this->microdata['DataType']['Text']));
    
    
    /*  -> Thing -> NutritionInformation */
    $this->microdata['Thing']['NutritionInformation']['calories'] = &$this->microdata['Thing']['Intangible']['Quantity']['Energy'];
    $this->microdata['Thing']['NutritionInformation']['carbohydrateContent'] = &$this->microdata['Thing']['Intangible']['Quantity']['Mass'];
    $this->microdata['Thing']['NutritionInformation']['cholesterolContent'] = &$this->microdata['Thing']['Intangible']['Quantity']['Mass'];
    $this->microdata['Thing']['NutritionInformation']['fatContent'] = &$this->microdata['Thing']['Intangible']['Quantity']['Mass'];
    $this->microdata['Thing']['NutritionInformation']['fiberContent'] = &$this->microdata['Thing']['Intangible']['Quantity']['Mass'];
    $this->microdata['Thing']['NutritionInformation']['proteinContent'] = &$this->microdata['Thing']['Intangible']['Quantity']['Mass'];
    $this->microdata['Thing']['NutritionInformation']['saturatedFatContent'] = &$this->microdata['Thing']['Intangible']['Quantity']['Mass'];
    $this->microdata['Thing']['NutritionInformation']['servingSize'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['NutritionInformation']['sodiumContent'] = &$this->microdata['Thing']['Intangible']['Quantity']['Mass'];
    $this->microdata['Thing']['NutritionInformation']['sugarContent'] = &$this->microdata['Thing']['Intangible']['Quantity']['Mass'];
    $this->microdata['Thing']['NutritionInformation']['transFatContent'] = &$this->microdata['Thing']['Intangible']['Quantity']['Mass'];
    $this->microdata['Thing']['NutritionInformation']['unsaturatedFatContent'] = &$this->microdata['Thing']['Intangible']['Quantity']['Mass'];
    
    
    /*  -> Thing -> Organization */
    $this->microdata['Thing']['Organization']['address'] = &$this->microdata['Thing']['Intangible']['StructuredValue']['ContactPoint']['PostalAddress'];
    $this->microdata['Thing']['Organization']['aggregateRating'] = &$this->microdata['Thing']['Intangible']['Rating']['AggregateRating'];
    $this->microdata['Thing']['Organization']['contactPoints'] = &$this->microdata['ContactPoint'];
    $this->microdata['Thing']['Organization']['email'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Organization']['employees'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Organization']['events'] = &$this->microdata['Thing']['Event'];
    $this->microdata['Thing']['Organization']['faxNumber'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Organization']['founders'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Organization']['foundingDate'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['Organization']['interactionCount'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Organization']['location'] = &$this->microdata['Thing']['Place'];
    $this->microdata['Thing']['Organization']['members'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Organization']['reviews'] = &$this->microdata['Thing']['CreativeWork']['Review'];
    $this->microdata['Thing']['Organization']['telephone'] = &$this->microdata['DataType']['Text'];
    
    
    /*  -> Thing -> Organization -> EducationalOrganization */
    $this->microdata['Thing']['Organization']['EducationalOrganization']['alumni'] = &$this->microdata['Thing']['Person'];
    
    
    /*  -> Thing -> Place -> Organization -> LocalBusiness */
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['branchOf'] = &$this->microdata['Thing']['Organization'];
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['currenciesAccepted'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['openingHours'] = &$this->microdata['Thing']['Intangible']['Quantity']['Duration'];
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['paymentAccepted'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['priceRange'] = &$this->microdata['DataType']['Text'];
    
    
    /*  -> Thing -> Place -> Organization -> LocalBusiness -> FoodEstablishment */
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['FoodEstablishment']['acceptsReservations'] = array('*mul' => array(&$this->microdata['DataType']['Text']['URL'], &$this->microdata['DataType']['Text']));
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['FoodEstablishment']['menu'] = array('*mul' => array(&$this->microdata['DataType']['Text']['URL'], &$this->microdata['DataType']['Text']));
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['FoodEstablishment']['servesCuisine'] = &$this->microdata['DataType']['Text'];
    
    
    /*  -> Thing -> Organization -> MusicGroup */
    $this->microdata['Thing']['Organization']['MusicGroup']['albums'] = &$this->microdata['Thing']['CreativeWork']['MusicPlaylist']['MusicAlbum'];
    $this->microdata['Thing']['Organization']['MusicGroup']['musicGroupMember'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Organization']['MusicGroup']['tracks'] = &$this->microdata['Thing']['CreativeWork']['MusicRecording'];
    
    
    /*  -> Thing -> Person */
    $this->microdata['Thing']['Person']['address'] = &$this->microdata['Thing']['Intangible']['StructuredValue']['ContactPoint']['PostalAddress'];
    $this->microdata['Thing']['Person']['affiliation'] = &$this->microdata['Thing']['Organization'];
    $this->microdata['Thing']['Person']['alumniOf'] = &$this->microdata['EducationalOrganization'];
    $this->microdata['Thing']['Person']['awards'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Person']['birthDate'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['Person']['children'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Person']['colleagues'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Person']['contactPoints'] = &$this->microdata['ContactPoint'];
    $this->microdata['Thing']['Person']['deathDate'] = &$this->microdata['DataType']['Date'];
    $this->microdata['Thing']['Person']['email'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Person']['faxNumber'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Person']['follows'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Person']['gender'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Person']['homeLocation'] = &$this->microdata['Thing']['Place'];
    $this->microdata['Thing']['Person']['interactionCount'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Person']['jobTitle'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Person']['knows'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Person']['memberOf'] = &$this->microdata['Thing']['Organization'];
    $this->microdata['Thing']['Person']['nationality'] = &$this->microdata['Country'];
    $this->microdata['Thing']['Person']['parents'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Person']['performerIn'] = &$this->microdata['Thing']['Event'];
    $this->microdata['Thing']['Person']['relatedTo'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Person']['siblings'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Person']['spouse'] = &$this->microdata['Thing']['Person'];
    $this->microdata['Thing']['Person']['telephone'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Person']['workLocation'] = &$this->microdata['Thing']['Place'];
    $this->microdata['Thing']['Person']['worksFor'] = &$this->microdata['Thing']['Organization'];
    
    
    /*  -> Thing -> Place */
    $this->microdata['Thing']['Place']['address'] = &$this->microdata['Thing']['Intangible']['StructuredValue']['ContactPoint']['PostalAddress'];
    $this->microdata['Thing']['Place']['aggregateRating'] = &$this->microdata['Thing']['Intangible']['Rating']['AggregateRating'];
    $this->microdata['Thing']['Place']['containedIn'] = &$this->microdata['Thing']['Place'];
    $this->microdata['Thing']['Place']['events'] = &$this->microdata['Thing']['Event'];
    $this->microdata['Thing']['Place']['faxNumber'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Place']['geo'] = &$this->microdata['Thing']['Intangible']['StructuredValue']['GeoCoordinates'];
    $this->microdata['Thing']['Place']['interactionCount'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Place']['maps'] = &$this->microdata['DataType']['Text']['URL'];
    $this->microdata['Thing']['Place']['photos'] = &$this->microdata['Thing']['CreativeWork']['Photograph'];
    $this->microdata['Thing']['Place']['reviews'] = &$this->microdata['Thing']['CreativeWork']['Review'];
    $this->microdata['Thing']['Place']['telephone'] = &$this->microdata['DataType']['Text'];
    
    
    /*  -> Thing -> Place -> CivicStructure */
    $this->microdata['Thing']['Place']['CivicStructure']['openingHours'] = &$this->microdata['Thing']['Intangible']['Quantity']['Duration'];
    
    
    /*  -> Thing -> Place -> Organization -> LocalBusiness */
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['branchOf'] = &$this->microdata['Thing']['Organization'];
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['currenciesAccepted'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['openingHours'] = &$this->microdata['Thing']['Intangible']['Quantity']['Duration'];
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['paymentAccepted'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['priceRange'] = &$this->microdata['DataType']['Text'];
    
    
    /*  -> Thing -> Place -> Organization -> LocalBusiness -> FoodEstablishment */
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['FoodEstablishment']['acceptsReservations'] = array('*mul' => array(&$this->microdata['DataType']['Text']['URL'], &$this->microdata['DataType']['Text']));
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['FoodEstablishment']['menu'] = array('*mul' => array(&$this->microdata['DataType']['Text']['URL'], &$this->microdata['DataType']['Text']));
    $this->microdata['Thing']['Place']['Organization']['LocalBusiness']['FoodEstablishment']['servesCuisine'] = &$this->microdata['DataType']['Text'];
    
    
    /*  -> Thing -> Product */
    $this->microdata['Thing']['Product']['aggregateRating'] = &$this->microdata['Thing']['Intangible']['Rating']['AggregateRating'];
    $this->microdata['Thing']['Product']['brand'] = &$this->microdata['Thing']['Organization'];
    $this->microdata['Thing']['Product']['manufacturer'] = &$this->microdata['Thing']['Organization'];
    $this->microdata['Thing']['Product']['model'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Product']['offers'] = &$this->microdata['Thing']['Intangible']['Offer'];
    $this->microdata['Thing']['Product']['productID'] = &$this->microdata['DataType']['Text'];
    $this->microdata['Thing']['Product']['reviews'] = &$this->microdata['Thing']['CreativeWork']['Review'];
  }
  
  /* get the hierarchy for any item */
  public function getHierarchy($item = null) {
    
    if ($item === null) {
      return null;
    }
    
    if ($item == 'Thing' || $item == 'DataType') {
      return array($item);
    }
    
    if (!$this->itemExists($item) && !$this->propertyExists($item)) {
      return null;
    }

    $hierarchy = array($item);
    $parent = $this->getParent($item);
    $hierarchy[] = $parent;
    
    while ($parent != 'Thing' && $parent != 'DataType') {
      $parent = $this->getParent($parent);
      $hierarchy[] = $parent;
    }
    
    return array_reverse($hierarchy);
  }
  
  /* get the parent of any item */
  public function getParent($item = null, $start = null, $reset = true) {
    
    if ($reset) {
      $this->_reset();
    }
    
    if ($this->_complete) {
      return $this->_parent;
    } else if ($item == 'Thing' || $item == 'DataType') {
      return null;
    }
       
    if ($item === null) {
      return null;
    }
    
    if ($start === null) {
      $start = &$this->microdata;
    }
    
    foreach ($start as $k => $v) {
      if ($this->_complete) {
        return $this->_parent;
      }
      
      /* ignore properties */
      if (!is_array($v)) {
       continue; 
      }
       
      if (isset($v[$item])) {
        /* found it */
        $this->_complete = true;
        $this->_parent = $k;
        break;
      } else if (count($v) > 0) {
        $this->getParent($item, $v, false);
      }
    }
    
    return $this->_parent;
  }
  
  /* get the properties of any item, optionally with inherited properties too */
  public function getProperties($item = null, $childPropertiesOnly = false) {
    
    if ($item === null) {
      return null;
    }
    
    /* get hierarchy */
    $itemHierarchy = $this->getHierarchy($item);
        
    $this->microdataCurrent = $this->microdata;
    $properties = array();
    
    foreach ($itemHierarchy as $v) {
      $this->microdataCurrent = $this->microdataCurrent[$v];
      if ($childPropertiesOnly && $v !== $item) {
        continue;
      }
      
      foreach ($this->microdataCurrent as $k => $v) {
        if (!is_array($v)) {
          $properties[] = $k;
        }
      }
    }
    return $properties;
  }
  
  /* get the child (or children) of a specific item */
  public function getChildren($item = null, $immediateChildrenOnly = false) {
    
    if ($item === null) {
      return null;
    }
    
    /* get hierarchy */
    $itemHierarchy = $this->getHierarchy($item);
    
    $this->microdataCurrent = $this->microdata;
    $children = array();
    
    foreach ($itemHierarchy as $v) {
      $this->microdataCurrent = $this->microdataCurrent[$v];
      if ($v !== $item) {
        continue;
      }
      
      foreach ($this->microdataCurrent as $k => $v) {
        if (is_array($v)) {
          if (!$immediateChildrenOnly) {
            $children[$k] = $this->getChildren($k);
          } else {
            $children[] = $k;
          }
        }
      }
    }
    return $children;
  }
  
  /* this allows you to call $obj->ItemName() */
  public function __call($name, $args) {
    return (count($args) > 0) ? $this->filter($name, $args[0]) : $this->filter($name);
  }
  
  /* usually called from $md->ItemName() - returns HTML to implement microdata */
  public function filter($item, $properties = array()) {
    
    if ($item === null) {
      return null;
    }
    
    if (!$this->itemExists($item)) {
      return null;
    }
    
    $microdata['open'] = '<div itemscope itemtype="http://schema.org/'.$item.'">';
    $microdata['close'] = '</div>';
    
    foreach ($properties as $k => $v) {
      if (!$this->propertyExists($k, $item)) {
        continue;
      }
      $microdata['properties'][] = '<span itemprop="'.$k.'">'.$v.'</span>';
    }
    
    return $microdata;
  }
  
  /* check whether an item exists */
  public function itemExists($item) {
  
    if ($item === null) {
      return null;
    }
    
    if (!preg_match('/^[A-Z]/', $item)) {
      return false;
    }
    
    if ($item == 'Thing' || $item == 'DataType') {
      return true;
    }
    
    return ($this->getParent($item) === null) ? false : true;
  }
  
  /* check whether an item has a specific property - optionally including all child properties */
  public function propertyExists($property, $item = null, $childPropertiesOnly = false) {
    
    if ($property === null) {
      return null;
    }
    
    if (!preg_match('/^[a-z]/', $property)) {
      return false;
    }
    
    $parent = $this->getParent($property);
    
    if ($parent === null) {
      return false;
    } else if ($item !== null) {
      if ($childPropertiesOnly) {
        return ($parent === $item) ? true : false;
      } else {
        return (in_array($parent, $this->getHierarchy($property))) ? true : false;
      }
    } else {
      return true;
    }
  }
  
  /* add a friendly reference to a specific item - needs implementing in other functions */
  public function addFriendlyReference($item = null, $friendlyName = null) {
    
    if ($item === null || $friendlyName === null) {
      return null;
    } else if ((!is_array($item) && is_array($friendlyName)) || (is_array($item) && !is_array($friendlyName))) {
      return null;
    }
    
    if (!is_array($item)) {
      $item = array($item);
      $friendlyName = array($friendlyName);
    }
    
    if (count($item) !== count($friendlyName)) {
      return null;
    }
    
    for ($x=0;$x<count($item);$x++) { echo "";
      if (!$this->itemExists($friendlyName[$x]) && $this->itemExists($item[$x])) { 
        $this->_friendlyReferences[$friendlyName[$x]] = $this->getHierarchy($item[$x]);
      }
    }
  }
  
  /* grab the whole microdata structure */
  public function getMicrodata() {
    return $this->microdata['Thing'];
  }
}
