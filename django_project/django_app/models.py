from django.db import models

class Card(models.Model):
    id = models.IntegerField(primary_key=True)
    image = models.CharField(max_length=255)
    description = models.TextField()
    name = models.CharField(max_length=255)
    owner = models.ForeignKey('FosUser', blank=True, null=True)
    def __unicode__(self):
        return "id:" + str(self.id) + " name:"+ self.name
    class Meta:
        managed = False
        db_table = 'Card'


class FosUser(models.Model):
    id = models.IntegerField(primary_key=True)
    username = models.CharField(max_length=255)
    username_canonical = models.CharField(unique=True, max_length=255)
    email = models.CharField(max_length=255)
    email_canonical = models.CharField(unique=True, max_length=255)
    enabled = models.IntegerField()
    salt = models.CharField(max_length=255)
    password = models.CharField(max_length=255)
    last_login = models.DateTimeField(blank=True, null=True)
    locked = models.IntegerField()
    expired = models.IntegerField()
    expires_at = models.DateTimeField(blank=True, null=True)
    confirmation_token = models.CharField(max_length=255, blank=True)
    password_requested_at = models.DateTimeField(blank=True, null=True)
    roles = models.TextField()
    credentials_expired = models.IntegerField()
    credentials_expire_at = models.DateTimeField(blank=True, null=True)
    def __unicode__(self):  # Python 3: def __str__(self):
        return self.username
    class Meta:
        managed = False
        db_table = 'fos_user'