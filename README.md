This is a system for blinded analysis of cell biological microscopy images. It is currently designed for analysis of actin polarity in yeast cells but could be extended for other purposes. 

Image files are pulled in random order and shown to the user via a web browser. The user assigns a category/score to each image. The results are then summarized by genotype, condition, or whatever variable is being tested, and a simple text file is created that can be further analyzed or used to create a chart.

The code is being utilized in an upcoming paper (not yet published). It is very lightweight and has basically no UI, so follow the instructions carefully. It requires a webserver with PHP and MySQL (such as a LAMP server); ideally, this is installed locally or in a protected directory.

* Download or fork and install on a webserver with PHP and MySQL.
* Create a new MySQL database called 'cellblind' and create a user with access to the database.
* Run the following command on cellblind: 

    CREATE TABLE IF NOT EXISTS \`actin_mutants\` (\`ID\` int(11) NOT NULL, \`filename\` tinytext NOT NULL, \`path\` mediumtext NOT NULL, \`condition\` tinytext NOT NULL, \`result\` int(11) DEFAULT NULL, PRIMARY KEY (\`ID\`))       

You can change 'actin_mutants' to something else but the column names should stay the same.

* Open config_sample.php and change the database host, username, password, and tablename (if you changed it above).
* Make sure your image files are sorted according to genotype, growth condition or whatever you are testing. Create a new folder called "DATA" within the main directory and copy the genotype folders and image files into there.
* Run `setup_analysis.php`. The database will be populated.
* Open `perform_analysis.php`. Score the images that appear according to their phenotype. When you are finished, new images will just stop showing up.
* If you need to start over, simply empty the table and run `setup_analysis.php` again to repopulate it.
* When satisfied, run `view_results.php`. A text file called `results_summary.txt` will appear. This can then be quantitaively analyzed.

