# Nerd Contact

Contact farming for nerd 🤓

Add and list people you meet or plan to meet and create your own strategy on how to approach them uniquely based on their interest and zodiac.

But remember to just enjoy your life.

## Installation in New GitHub Codespace Instance

Please refer to [the installation wiki]("https://github.com/wahyusa/nerd-contact/wiki/Setup-a-Fresh-GitHub-Codespace-for-Laravel-12-Development") because it was too long

## Usage

### Basic

https://localhost/api/contacts
https://localhost/api/zodiacs
https://localhost/api/contacts-stats

### Search

https://localhost/api/contacts?search=john
https://localhost/api/contacts?search=doe
https://localhost/api/contacts?search=gmail

### Filter

https://localhost/api/contacts?tag=nerd
https://localhost/api/contacts?tag=friend
https://localhost/api/contacts?zodiac=1
https://localhost/api/contacts?favorites=true

### Pagination

https://localhost/api/contacts?page=2
https://localhost/api/contacts?per_page=5
https://localhost/api/contacts?page=2&per_page=10

### Sorting

https://localhost/api/contacts?sort_by=last_name&sort_order=desc
https://localhost/api/contacts?sort_by=created_at&sort_order=desc
https://localhost/api/contacts?sort_by=email&sort_order=asc

### Combined

https://localhost/api/contacts?search=john&tag=nerd&sort_by=first_name
https://localhost/api/contacts?zodiac=1&per_page=5&sort_order=desc
