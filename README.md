# share_user

Private rsa key is important for decrypting of data from Database. It located in private.txt in 'wp-admin' folder, so if data was encrypted and this file not exists- plugin will generate new private and public keys, data will not be decrypted and instead of data in Database in user meta fields will be default values. To read data from DB replace new 'private.txt' with old 'private.txt'.

Attention: DO NOT UPDATE user meta field if their values was lost but you still have private-key. Just place private-key in 'private.txt' in folder wp-admin, and data from database will displayed again. If you do not have private key: you will not decrypt data and the best way for you will be to update users meta fields and save new 'private.txt' in 'wp-admin' for yourself.