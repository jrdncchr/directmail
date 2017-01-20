<?php

class Seeder extends CI_Controller {

    public function user($count = 20) 
    {
        if (is_cli()) {
            $this->load->model('user_model');
            $this->user_model->truncate();
            $admin = array(
                'id' => 2,
                'email' => 'directmail@gmail.com',
                'first_name' => 'Jordan',
                'last_name' => 'Cachero',
                'contact_no' => '09162553791',
                'company_id' => 1,
                'role_id' => 3,
                'deleted' => 0,
                'confirmed' => 1
            );
            $this->user_model->add_test_user($admin);

            $faker = Faker\Factory::create();
            for ($i = 0; $i < $count; $i++) {
                $user = array(
                    'email' => $faker->email,
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'contact_no' => $faker->phoneNumber,
                    'company_id' => 1,
                    'role_id' => 0,
                    'deleted' => 0,
                    'confirmed' => 1
                );
                $this->user_model->add_test_user($user);
            }
        }
    }

    public function property($count = 100)
    {
        if (is_cli()) {
            $this->load->model('property_model');
            $this->property_model->truncate();
            $this->property_model->truncate_comment();

            $faker = Faker\Factory::create();
            for ($i = 0; $i < $count; $i++) {
                $property = array(
                    'list_id' => rand(1, 3),
                    'status' => 'pending',
                    'funeral_home' => $faker->address,
                    'property_first_name' => $faker->firstName,
                    'property_middle_name' => $faker->lastName,
                    'property_last_name' => $faker->lastName,
                    'property_address' => $faker->address,
                    'property_city' => $faker->city,
                    'property_state' => $faker->citySuffix,
                    'property_zipcode' => $faker->postcode,
                    'pr_first_name' => $faker->firstName,
                    'pr_middle_name' => $faker->lastName,
                    'pr_last_name' => $faker->lastName,
                    'pr_address' => $faker->address,
                    'pr_city' => $faker->city,
                    'pr_state' => $faker->citySuffix,
                    'pr_zipcode' => $faker->postcode,
                    'attorney_name' => $faker->name,
                    'attorney_first_address' => $faker->address,
                    'attorney_second_address' => $faker->address,
                    'attorney_city' => $faker->city,
                    'attorney_state' => $faker->citySuffix,
                    'attorney_zipcode' => $faker->postcode,
                    'mail_first_name' => $faker->firstName,
                    'mail_last_name' => $faker->lastName,
                    'mail_address' => $faker->address,
                    'mail_city' => $faker->city,
                    'mail_state' => $faker->citySuffix,
                    'mail_zipcode' => $faker->postcode,
                    'start_quarterly_mail' => rand(0, 1),
                    'elligible_letter_mailings' => rand(0, 1),
                    'elligible_postcard_mailings' => rand(0, 1),
                    'created_by' => rand(1, 50)
                );
                $result = $this->property_model->save($property);

                for ($x = 0; $x < rand(3, 10); $x++) {
                    $comment = array(
                        'property_id' => $result['id'],
                        'type' => 'comment',
                        'user_id' => rand(2, 22),
                        'comment' => $faker->sentence,
                        'date_created' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
                    );
                    $this->property_model->save_comment($comment);
                }
            }
        }
    }

    public function list_paragraphs($count = 30)
    {
         if (is_cli()) {
            $this->load->model('list_model');
            $this->list_model->truncate_list_paragraph();

            $types = array('intro', 'second', 'bbb', 'kim', 'cta', 'ps');
            $intro = 0;
            $second = 0;
            $bbb = 0;
            $kim = 0;
            $cta = 0;
            $ps = 0;

            $faker = Faker\Factory::create();
        
            for ($i = 0; $i < $count; $i++) {
                $paragraph = array(
                    'list_id' => rand(1, 3),
                    'type' => $types[rand(0, 5)]
                );
                $paragraph['number'] = ${$paragraph['type']} == 0 ? 1 : ${$paragraph['type']}+1;
                ${$paragraph['type']}++;
                $paragraph['content'] = $faker->paragraph;
                $this->list_model->insert_paragraph($paragraph);
            }
         }
    }

    public function list_bullet_points($count = 30) 
    {
         if (is_cli()) {
            $this->load->model('list_model');
            $this->list_model->truncate_list_bullet_points();

            $faker = Faker\Factory::create();
            for ($i = 0; $i < $count; $i++) {
                $bullet_point = array(
                    'list_id' => rand(1, 3),
                    'number' => 1,
                    'content' => $faker->sentence
                );
                $this->list_model->insert_bullet_point($bullet_point);
            }
         }
    }

    public function list_testimonials($count = 30) 
    {
         if (is_cli()) {
            $this->load->model('list_model');
            $this->list_model->truncate_list_testimonials();

            $faker = Faker\Factory::create();
            for ($i = 0; $i < $count; $i++) {
                $testimonial = array(
                    'list_id' => rand(1, 3),
                    'number' => 1,
                    'content' => $faker->paragraph
                );
                $this->list_model->insert_testimonial($testimonial);
            }
         }
    }

}
