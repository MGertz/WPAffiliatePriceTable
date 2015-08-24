Dette er README.md filen til projektet.

Lidt info om hvordan man tjekker ud

Git global setup

git config --global user.name "Michael"
git config --global user.email "michael@ringhus.dk"

Create a new repository

git clone git@gitlab.com:RinghusDK/AffiliatePriceTable.git
cd AffiliatePriceTable
touch README.md
git add README.md
git commit -m "add README"
git push -u origin master

Existing folder or Git repository

cd existing_folder
git init
git remote add origin git@gitlab.com:RinghusDK/AffiliatePriceTable.git
git add .
git commit
git push -u origin master
