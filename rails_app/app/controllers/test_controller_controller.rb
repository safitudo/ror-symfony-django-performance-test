class TestControllerController < ApplicationController
  # GET /cards_test
  def test
    @owner_id = 10521598
    @user = User.find(@owner_id)
    @cards = Card
    .select('Card.*, count(users_cards_likes.card_id) as likes_num, count(users_cards_followers.card_id) as followers_num')
    .joins('JOIN users_cards_likes ON users_cards_likes.card_id=Card.id')
    .joins('JOIN users_cards_followers ON users_cards_followers.card_id=Card.id')
    .where('owner_id=?', @owner_id)
    .group('Card.id')
    @some = ''
  end

  # GET /random
  def random
    @min_user_id = 10521598
    @max_user_id = @min_user_id + 1000
    @owner_id = rand(1000) + @min_user_id
    @user = User.find(@owner_id)
    @cards = Card
    .select('Card.*, count(users_cards_likes.card_id) as likes_num, count(users_cards_followers.card_id) as followers_num')
    .joins('JOIN users_cards_likes ON users_cards_likes.card_id=Card.id')
    .joins('JOIN users_cards_followers ON users_cards_followers.card_id=Card.id')
    .where('owner_id=?', @owner_id)
    .group('Card.id')
  end

  # GET /static
  def static

  end
end
