<?php
    session_start();
    // Set up faker library to be used
    require_once("/vendor/fzaninotto/faker/src/autoload.php");
    $faker = Faker\Factory::create();
    // Set up db connection
    $db = new mysqli("localhost", "root", "mysql", "paws_test");
    // Make sure connection went through
    if ($db->connect_errno) { echo $db->connect_error; }

    $data = array(
        "owners" => array(),
        "cats" => array(),
        "dogs" => array(),
        "exotics" => array(),
        "catNotes" => array(),
        "dogNotes" => array(),
        "exoticNotes" => array(),
        "catsOwners" => array(),
        "dogsOwners" => array(),
        "exoticsOwners" => array()
    );
    for($i = 0; $i < 1000; $i++) {
        // OWNERS=======================================================================================================
        $owner = array();
        $owner['id'] = $i + 1;
        $owner['fname'] = $faker->firstName($gender = null|'male'|'female');
        $owner['lname'] = $faker->lastName;
        $owner['add1'] = $faker->buildingNumber . " " . $faker->streetName;
        $owner['add2'] = "";
        if ($faker->boolean) {
            $owner['add2'] = $faker->secondaryAddress;
        }
        $owner['city'] = $faker->city;
        $owner['st'] = $faker->stateAbbr;
        $owner['zip'] = $faker->randomNumber($nDigits = 5, $strict = true);
        $data['owners'][$i] = $owner;
        // Insert owner into db
        $insertOwner = "INSERT INTO owners(id,fname,lname,add1,add2,city,st,zip,isAdmin) VALUES(" . $owner['id'] . ",\"" . $owner['fname'] . "\",\"" . $owner['lname'] . "\",\"" . $owner['add1'] . "\",\"" . $owner['add2'] . "\",\"" . $owner['city'] . "\",\"" . $owner['st'] . "\"," . $owner['zip'] . ",0)";
        // echo $insertOwner . "<br>";
        if (!$db->query($insertOwner)) { echo "[ERROR]<br>" . $insertOwner . "<br>" . $db->error . "<br>[END ERROR]<br>"; }
        //==============================================================================================================

        // CATS=========================================================================================================
        $cat = array();
        $cat['id'] = $i + 1;
        $cat['name'] = $faker->firstName;
        $cat['breed'] = $faker->randomElement([
            "Sphynx",
            "Calico",
            "British Shorthair",
            "Persian", "Siamese",
            "Maine Coon","Ragdoll",
            "Burmese","American Shorthair",
            "Abyssinian",
            "Bengal",
            "American Bobtail",
            "Siberian",
            "Russian Blue"]);
        $cat['sex'] = $faker->randomElement(["m","f"]);
        $cat['shots'] = $faker->numberBetween(0,1);
        $cat['declawed'] = $faker->numberBetween(0,1);
        $cat['neutered'] = $faker->numberBetween(0,1);
        $cat['birthdate'] = $faker->dateTimeBetween("-9 years", "now")->format("Y-m-d");
        $data['cats'][$i] = $cat;
        $insertCat = "INSERT INTO cats(id,name,breed,sex,shots,declawed,neutered,birthdate) VALUES(" . $cat['id'] . ",\"" . $cat['name'] . "\",\"" . $cat['breed'] . "\",\"" . $cat['sex'] . "\"," . $cat['shots'] . "," . $cat['declawed'] . "," . $cat['neutered'] . ",\"" . $cat['birthdate'] . "\")";
        // echo $insertCat . "<br>";
        if (!$db->query($insertCat)) { echo "[ERROR]: Couldn't insert CAT"; }
        //==============================================================================================================

        // DOGS=========================================================================================================
        $dog = array();
        $dog['id'] = $i + 1;
        $dog['name'] = $faker->firstName;
        $dog['breed'] = $faker->randomElement([
            "German Shepherd",
            "Labrador Retriever",
            "Bulldog",
            "Poodle",
            "Beagle",
            "Golden Retriever",
            "Chihuahua",
            "Pug",
            "Yorkshire Terrier",
            "Rottweiler",
            "Siberian Husky",
            "Boxer",
            "French Bulldog",
            "English Mastiff"]);
        $dog['sex'] = $faker->randomElement(["m","f"]);
        $dog['shots'] = $faker->numberBetween(0,1);
        $dog['licensed'] = $faker->numberBetween(0,1);
        $dog['neutered'] = $faker->numberBetween(0,1);
        $dog['birthdate'] = $faker->dateTimeBetween("-9 years", "now")->format("Y-m-d");
        $dog['weight'] = $faker->numberBetween(25, 200);
        $data['dogs'][$i] = $dog;
        $insertDog = "INSERT INTO dogs(id,name,breed,sex,shots,licensed,neutered,birthdate,weight) VALUES(" . $dog['id'] . ",\"" . $dog['name'] . "\",\"" . $dog['breed'] . "\",\"" . $dog['sex'] . "\"," . $dog['shots'] . "," . $dog['licensed'] . "," . $dog['neutered'] . ",\"" . $dog['birthdate'] . "\"," . $dog['weight'] . ")";
        // echo $insertDog . "<br>";
        if (!$db->query($insertDog)) { echo "[ERROR]: Couldn't insert DOG"; }
        //==============================================================================================================

        // EXOTICS======================================================================================================
        $exotic = array();
        $exotic['id'] = $i + 1;
        $exotic['name'] = $faker->firstName;
        $exotic['species'] = $faker->randomElement([
            "Crested Gecko",
            "Bearded Dragon",
            "Green Iguana",
            "Blue-tongued Skink",
            "Owl",
            "Parrot",
            "Pigeon",
            "Falcon",
            "Golden Hamster",
            "Wood Mouse",
            "Garter Snake",
            "Water Snakes",
            "Black Rat Snake",
            "Corn Snake"]);
        $exotic['sex'] = $faker->randomElement(["m","f"]);
        $exotic['neutered'] = $faker->numberBetween(0,1);
        $exotic['birthdate'] = $faker->dateTimeBetween("-9 years", "now")->format("Y-m-d");
        $data['exotics'][$i] = $exotic;
        $insertExotic = "INSERT INTO exotics(id,name,species,sex,neutered,birthdate) VALUES(" . $exotic['id'] . ",\"" . $exotic['name'] . "\",\"" . $exotic['species'] . "\",\"" . $exotic['sex'] . "\"," . $exotic['neutered'] . ",\"" . $exotic['birthdate'] . "\")";
        // echo $insertExotic . "<br>";
        if (!$db->query($insertExotic)) { echo "[ERROR]: Couldn't insert EXOTIC"; }
        //==============================================================================================================

        // NOTES========================================================================================================
        $ownerNotes = array();
        $ownerNotes['id'] = null;
        $ownerNotes['ownersFk'] = $owner['id'];
        $ownerNotes['vetName'] = ($faker->firstName . " " . $faker->lastName);
        $ownerNotes['date'] = $faker->dateTimeBetween("-2 years", "now")->format("Y-m-d");
        $ownerNotes['note'] = $faker->paragraph(5, true);
        $data['ownerNotes'][$i] = $ownerNotes;
        $insertOwnerNotes = "INSERT INTO ownerNotes(id,ownersFk,vetName,date,note) VALUES(NULL," . $ownerNotes['ownersFk'] . ",\"" . $ownerNotes['vetName'] . "\",\"" . $ownerNotes['date'] . "\",\"" . $ownerNotes['note'] . "\")";
        if (!$db->query($insertOwnerNotes)) { echo "[ERROR]: Couldn't insert OWNERNOTES"; }

        $catNotes = array();
        $catNotes['id'] = null;
        $catNotes['catsFk'] = $cat['id'];
        $catNotes['vetName'] = ($faker->firstName . " " . $faker->lastName);
        $catNotes['date'] = $faker->dateTimeBetween("-2 years", "now")->format("Y-m-d");
        $catNotes['note'] = $faker->paragraph(5, true);
        $data['catNotes'][$i] = $catNotes;
        $insertCatNotes = "INSERT INTO catNotes(id,catsFk,vetName,date,note) VALUES(NULL," . $catNotes['catsFk'] . ",\"" . $catNotes['vetName'] . "\",\"" . $catNotes['date'] . "\",\"" . $catNotes['note'] . "\")";
        if (!$db->query($insertCatNotes)) { echo "[ERROR]: Couldn't insert CATNOTES"; }

        $dogNotes = array();
        $dogNotes['id'] = null;
        $dogNotes['dogsFk'] = $dog['id'];
        $dogNotes['vetName'] = ($faker->firstName . " " . $faker->lastName);
        $dogNotes['date'] = $faker->dateTimeBetween("-2 years", "now")->format("Y-m-d");
        $dogNotes['note'] = $faker->paragraph(5, true);
        $data['dogNotes'][$i] = $dogNotes;
        $insertDogNotes = "INSERT INTO dogNotes(id,dogsFk,vetName,date,note) VALUES(NULL," . $dogNotes['dogsFk'] . ",\"" . $dogNotes['vetName'] . "\",\"" . $dogNotes['date'] . "\",\"" . $dogNotes['note'] . "\")";
        if (!$db->query($insertDogNotes)) { echo "[ERROR]: Couldn't insert DOGNOTES"; }

        $exoticNotes = array();
        $exoticNotes['id'] = null;
        $exoticNotes['exoticsFk'] = $exotic['id'];
        $exoticNotes['vetName'] = ($faker->firstName . " " . $faker->lastName);
        $exoticNotes['date'] = $faker->dateTimeBetween("-2 years", "now")->format("Y-m-d");
        $exoticNotes['note'] = $faker->paragraph(5, true);
        $data['exoticNotes'][$i] = $exoticNotes;
        $insertExoticNotes = "INSERT INTO exoticNotes(id,exoticsFk,vetName,date,note) VALUES(NULL," . $exoticNotes['exoticsFk'] . ",\"" . $exoticNotes['vetName'] . "\",\"" . $exoticNotes['date'] . "\",\"" . $exoticNotes['note'] . "\")";
        if (!$db->query($insertExoticNotes)) { echo "[ERROR]: Couldn't insert EXOTICNOTES"; }
        //==============================================================================================================
    }
    // LINK OWNERS TO ANIMALS==============================================================================================
    // current index for each animalOwners entry
    $catsIndex = 0;
    $dogsIndex = 0;
    $exoticsIndex = 0;
    // booleans to determine if we are done with that particular animal
    $moreCats = true;
    $moreDogs = true;
    $moreExotics = true;

    // loop 1000 times again (yikes)
    for ($i = 0; $i < 1000; $i++) {
        // determine how many pets they are going to own an animal
        // I want about 3-6% to NOT own animals (about 50, because this should be pretty rare)
        $numCats = ($moreCats ? $faker->numberBetween(0,2) : 0);
        $numDogs = ($moreDogs ? $faker->numberBetween(0,2) : 0);
        $numExotics = ($moreExotics ? $faker->numberBetween(0,2) : 0);

        if ($numCats != 0 || $numDogs != 0 || $numExotics != 0) {
            // assign cats
            for ($k = 0; $k < $numCats; $k++) {
                // make sure another cat is available to be added
                if (isset($data['cats'][$catsIndex])) {
                    $data['catsOwners'][$catsIndex]['id'] = null;
                    $data['catsOwners'][$catsIndex]['ownersFk'] = $data['owners'][$i]['id'];
                    $data['catsOwners'][$catsIndex]['catsFk'] = $data['cats'][$catsIndex]['id'];
                    $insertCatsOwners = "INSERT INTO catsOwners(id,catsFk,ownersFk) VALUES(NULL," . $data['cats'][$catsIndex]['id'] . "," . $data['owners'][$i]['id'] . ")";
                    if (!$db->query($insertCatsOwners)) { echo "[ERROR]: Couldn't insert CATOWNERS"; }
                    $catsIndex++;
                } else { $moreCats = false; }
            }
            for ($k = 0; $k < $numDogs; $k++) {
                // make sure another dog is available to be added
                if (isset($data['dogs'][$dogsIndex])) {
                    $data['dogsOwners'][$dogsIndex]['id'] = null;
                    $data['dogsOwners'][$dogsIndex]['ownersFk'] = $data['owners'][$i]['id'];
                    $data['dogsOwners'][$dogsIndex]['dogsFk'] = $data['dogs'][$dogsIndex]['id'];
                    $insertDogsOwners = "INSERT INTO dogsOwners(id,dogsFk,ownersFk) VALUES(NULL," . $data['dogs'][$dogsIndex]['id'] . "," . $data['owners'][$i]['id'] . ")";
                    if (!$db->query($insertDogsOwners)) { echo "[ERROR]: Couldn't insert DOGOWNERS"; }
                    $dogsIndex++;
                } else { $moreDogs = false; }
            }
            for ($k = 0; $k < $numExotics; $k++) {
                // make sure another exotic is available to be added
                if (isset($data['exotics'][$exoticsIndex])) {
                    $data['exoticsOwners'][$exoticsIndex]['id'] = null;
                    $data['exoticsOwners'][$exoticsIndex]['ownersFk'] = $data['owners'][$i]['id'];
                    $data['exoticsOwners'][$exoticsIndex]['exoticsFk'] = $data['exotics'][$exoticsIndex]['id'];
                    $insertExoticsOwners = "INSERT INTO exoticsOwners(id,exoticsFk,ownersFk) VALUES(NULL," . $data['exotics'][$exoticsIndex]['id'] . "," . $data['owners'][$i]['id'] . ")";
                    if (!$db->query($insertExoticsOwners)) { echo "[ERROR]: Couldn't insert EXOTICOWNERS"; }
                    $exoticsIndex++;
                } else { $moreExotics = false; }
            }
        }
    }
    //=======================================================================================================================
?>