<!-- commandas to run before pusing to git -->

php artisan optimize:clear

php artisan cache:clear

php artisan config:clear
php artisan view:clear
composer format
yarn cache clean
rm -rf node_modules
rm yarn.lock
yarn install
yard build
yarn lint

# TWWDA-Eboard

# Ensure you are on the master branch

git checkout master

# Pull the latest changes to make sure you're up to date

git pull origin master

# Create the main branch based on master

git checkout -b main

# Push the main branch to your remote repository

git push origin main

### Step 2: Create a Feature Branch

Now, create a feature branch from `main` where you can work independently:

# Switch to the main branch

git checkout main

# Create a new branch for your module work

git checkout -b feature-module

# (Optional) Push the feature branch to remote to track it

git push origin feature-module

### Step 3: Make Changes and Commit

Work on your module in the `feature-module` branch. Commit your changes regularly:

# Make changes to your files

git add .
git commit -m "Describe your changes here"

### Step 4: Push Changes and Prepare for Merge

Once you are done with changes and testing:

Push your changes

git push origin feature-module

# Optionally, you can create a pull request on GitHub from `feature-module` to `main`

# Or you can merge locally:

git checkout main
git pull origin main # Ensure main is up to date
git merge feature-module
git push origin main

### Step 5: Merge Main into Master

After your changes in `main` are stable and tested:

# Switch to master

git checkout master
git pull origin master # Ensure master is up to date
git merge main
git push origin master

### Step 6: Keep Your Local Master Updated

Whenever you need the latest stable version:

# Make sure you are on master and pull the latest changes

git checkout master
git pull origin master

This workflow keeps your `master` branch stable while allowing development and testing in branches. It's a robust method to manage development in teams or even for solo projects
