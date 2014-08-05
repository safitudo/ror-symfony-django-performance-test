from django.shortcuts import render
from django.db import connection
import random
from django_app.models import FosUser


def index(request):
    cursor = connection.cursor()
    owner_id = '10521598'
    user = FosUser.objects.get(id=owner_id)
    cursor.execute((
        "SELECT Card.id, Card.name, Card.description, count(l.card_id) as l_count, count(f.card_id) as f_count "
"FROM "
    "Card "
"LEFT JOIN "
    "users_cards_followers as f ON Card.id = f.card_id "
"LEFT JOIN "
	"users_cards_likes as l ON Card.id = l.card_id "
"WHERE "
    "Card.owner_id = " + owner_id + " "
"GROUP BY Card.id"
    ))
    cards = cursor.fetchall()
    return render(request, 'index.html', {'cards': cards, 'user': user})

def randomuser(request):
    min_user_id = 10521598
    max_user_id = min_user_id + 1000
    owner_id = str(random.randint(min_user_id, max_user_id))
    user = FosUser.objects.get(id=owner_id)
    cursor = connection.cursor()
    cursor.execute((
        "SELECT Card.id, Card.name, Card.description, count(l.card_id) as l_count, count(f.card_id) as f_count "
"FROM "
    "Card "
"LEFT JOIN "
    "users_cards_followers as f ON Card.id = f.card_id "
"LEFT JOIN "
	"users_cards_likes as l ON Card.id = l.card_id "
"WHERE "
    "Card.owner_id = " + owner_id + " "
"GROUP BY Card.id"
    ))
    cards = cursor.fetchall()
    return render(request, 'index.html', {'cards': cards, 'user': user})

def staticpage(request):
    return render(request, 'static.html')