Motorbike bundle store 
==========

MotorbikeBundle used to create and store registered motor bike in database .

## requirements

symfony >= 2.7

php > 5.4 

imagick

## installation

	composer require rth/motorbike-bundle "dev-master"

in your AppKernel.php file add following line :

	public function registerBundles()
		{
			$bundles = array(
			.
			.
			.
			.
			new \Rth\MotorbikeBundle\RthMotorbikeBundle(), // Motorbike bundle
			)
		}

now add these lines in app/config.yml

        rth_motorbike:
            general:
                upload_directory: "uploads" # upload directory name
                upload_path: "%kernel.root_dir%/../web/uploads" # upload path will be this. do not change it!
                image_tumbnail_width: 50 # image thumbnail width , imagick resizer
                image_tumbnail_height: 50 # image thumbnail height , imagick resizer
		
		
update database schema 

		doctrine:schema:update --force
		
		
## How to use ?

well you must first make your security system config then you need registered user with ROLE_ADMIN to have access 
to following admin page to add or list motorbikes .

        example.host/admin/motorbike  

public page

        example.host/motorbike 

## To Do 

adding motorbike edit page .

