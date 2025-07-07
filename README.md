# Nerd Contact

Contact farming for nerd 🤓

Add and list people you meet or plan to meet and create your own strategy on how to approach them uniquely based on their interest and zodiac.

But remember to just enjoy your life.

## Usage

### Basic

http://localhost:8000/api/contacts
http://localhost:8000/api/zodiacs
http://localhost:8000/api/contacts-stats

### Search

http://localhost:8000/api/contacts?search=john
http://localhost:8000/api/contacts?search=doe
http://localhost:8000/api/contacts?search=gmail

### Filter

http://localhost:8000/api/contacts?tag=nerd
http://localhost:8000/api/contacts?tag=friend
http://localhost:8000/api/contacts?zodiac=1
http://localhost:8000/api/contacts?favorites=true

### Pagination

http://localhost:8000/api/contacts?page=2
http://localhost:8000/api/contacts?per_page=5
http://localhost:8000/api/contacts?page=2&per_page=10

### Sorting

http://localhost:8000/api/contacts?sort_by=last_name&sort_order=desc
http://localhost:8000/api/contacts?sort_by=created_at&sort_order=desc
http://localhost:8000/api/contacts?sort_by=email&sort_order=asc

### Combined

http://localhost:8000/api/contacts?search=john&tag=nerd&sort_by=first_name
http://localhost:8000/api/contacts?zodiac=1&per_page=5&sort_order=desc