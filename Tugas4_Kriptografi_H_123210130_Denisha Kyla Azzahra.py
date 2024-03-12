# Sayang Sani (123210044)
# Denisha Kyla Azzahra (123210130)
# IF-H

import re
import os

def encrypt_vigenere(plaintext,key,preserve_whitespaces):
    """Encrypt the plaintext using vigenere cipher with custom key"""
    if(preserve_whitespaces.upper()!='Y'): 
        # removing spaces from the plaintext using regex
        plaintext=re.sub(r"\s+", "", plaintext.upper())
    else:
        plaintext=plaintext.upper()
    # removing spaces from the key using regex
    key=re.sub(r"\s+", "", key.upper())
    ciphertext=""
    # index for the key just in case some of the character are not in alphabet
    idx=0
    for i in range(len(plaintext)):
        if plaintext[i]>'Z' or plaintext[i]<'A':
            ciphertext+=plaintext[i]
        else:
            ciphertext+=chr(65+(ord(plaintext[i])-65+ord(key[idx%len(key)])-65)%26)
            idx+=1
    return ciphertext

def decrypt_vigenere(ciphertext,key):
    """Decrypt the message that was encrypted using vigenere cipher with custom key"""
    ciphertext=ciphertext.upper()
    # removing spaces from the key using regex
    key=re.sub(r"\s+", "", key.upper())
    plaintext=""
    # index for the key just in case some of the character are not in alphabet
    idx=0
    for i in range(len(ciphertext)):
        if ciphertext[i]>'Z' or ciphertext[i]<'A':
            plaintext+=ciphertext[i]
        else:
            plaintext+=chr(65+(ord(ciphertext[i])-65-(ord(key[idx%len(key)])-65))%26)
            idx+=1
    return plaintext

def encrypt_rail_fence(plaintext,key,preserve_whitespaces):
    """Encrypt the plaintext using rail fence cipher with custom key"""
    if(preserve_whitespaces.upper()!='Y'):
        # removing spaces from the plaintext using regex
        plaintext=re.sub(r"\s+", "", plaintext.upper())
    ciphertext=""
    if(key>len(plaintext)):
        return plaintext
    else:
        for i in range(key):
            for j in range(len(plaintext)):
                if j%((key-1)*2)==i or ((key-1)*2-j)%((key-1)*2)==i:
                    ciphertext+=plaintext[j]
        return ciphertext

def decrypt_rail_fence(ciphertext,key):
    """Decrypt the message that was encrypted using rail fence cipher with custom key"""
    plaintext=""
    if(key>len(ciphertext)):
        return ciphertext
    else:
        # matrix of spaces with number of columns = len(ciphertext) and number of rows = key
        matrix = [['' for _ in range(len(ciphertext))] for _ in range(key)]
        # direction 1 = down, direction -1 = up
        direction = 1
        row,col = 0,0
        # fill the matrix with '*' to simulate the rail fence
        for letter in ciphertext:
            matrix[row][col]='*'
            row+=direction
            # change direction if reaching the top or bottom rail
            if row==0 or row==key-1:
                direction*=-1
            col+=1
        # change the '*' with each character of the encrypted message
        index = 0
        for i in range(key):
            for j in range(len(ciphertext)):
                if matrix[i][j]=='*' and index<len(ciphertext):
                    matrix[i][j]=ciphertext[index]
                    index+=1
        # read off the plaintext from the matrix
        for i in range(len(ciphertext)):
            for j in range(key):
                if matrix[j][i]!='':
                    plaintext+=matrix[j][i]
        return plaintext

def encrypt_caesar(plaintext,key,preserve_whitespaces):
    """Encrypt the plaintext using caesar cipher with custom key"""
    if(preserve_whitespaces.upper()!='Y'): 
        # removing spaces from the plaintext using regex
        plaintext=re.sub(r"\s+", "", plaintext)
    ciphertext=""
    temp=""
    for letter in plaintext:
        if letter.upper()<'A' or letter.upper()>'Z':
            # just in case there are non alphabetical character
            ciphertext+=letter
        else:
            if (ord(letter)+key<65 or ord(letter)+key>90) and (letter>='A' and letter<='Z'):
                # if the ASCII for A-Z is out of range, go back to 'A' (65)
                temp=chr(65+(ord(letter)-65+key)%26)
            elif (ord(letter)+key<97 or ord(letter)+key>122) and (letter>='a' and letter<='z'):
                # if the ASCII for a-z is out of range, go back to 'a' (97)
                temp=chr(97+(ord(letter)-97+key)%26)
            else:
                temp=chr(ord(letter)+key)
            ciphertext+=temp
    return ciphertext

def decrypt_caesar(ciphertext,key):
    """Decrypt the message that was encrypted using caesar cipher with custom key"""
    plaintext=""
    for letter in ciphertext:
        if letter.upper()<'A' or letter.upper()>'Z':
            # just in case there are non alphabetical character
            plaintext+=letter
        else:
            if (ord(letter)-key<65 or ord(letter)-key>90) and (letter>='A' and letter<='Z'):
                # if the ASCII for A-Z is out of range, go back to 'A' (65)
                temp=chr(65+(ord(letter)-65-key)%26)
            elif (ord(letter)-key<97 or ord(letter)-key>122) and (letter>='a' and letter<='z'):
                # if the ASCII for a-z is out of range, go back to 'a' (97)
                temp=chr(97+(ord(letter)-97-key)%26)
            else:
                temp=chr(ord(letter)-key)
            plaintext+=temp
    return plaintext

def vigenere():
    """Interface of menu 1 (Vigenere Cipher)"""
    os.system('cls')
    print("++=================================================++")
    print("||                 VIGENERE CIPHER                 ||")
    print("++=================================================++\n")
    print("1. Encryption")
    print("2. Decryption\n")
    menu=input("Choose : ")
    if(menu=='1'):
        valid=False
        while(not valid):
            plaintext=input("\nPlaintext\t\t\t: ")
            check_plaintext=re.sub(r"\s+", "", plaintext)
            if(check_plaintext==""):
                print("\nPlaintext can't be empty!")
            else:
                valid=True
        valid=False
        while(not valid):
            key=input("Key (words/sentence)\t\t: ")
            check_key=re.sub(r"\s+", "", key)
            if(check_key==""):
                print("\nKey can't be empty!\n")
            elif(not check_key.isalpha()):
                print("\nYou can only use alphabet and space for the key!\n")
            else:
                valid=True
        preserve_whitespaces=input("Preserve whitespaces? [y/n]\t: ")
        ciphertext=encrypt_vigenere(plaintext,key,preserve_whitespaces)
        print("\nYour encrypted text is \"{}\"".format(ciphertext))
    elif(menu=='2'):
        valid=False
        while(not valid):
            ciphertext=input("\nEncrypted message\t: ")
            check_ciphertext=re.sub(r"\s+", "", ciphertext)
            if(check_ciphertext==""):
                print("\nCiphertext can't be empty!")
            else:
                valid=True
        valid=False
        while(not valid):
            key=input("Key (words/sentence)\t: ")
            check_key=re.sub(r"\s+", "", key)
            if(check_key==""):
                print("\nKey can't be empty!\n")
            elif(not check_key.isalpha()):
                print("\nYou can only use alphabet and space for the key!\n")
            else:
                valid=True
        plaintext=decrypt_vigenere(ciphertext,key)
        print("\nYour decrypted text is \"{}\"".format(plaintext))

def rail_fence():
    """Interface of menu 1 (Rail Fence Cipher)"""
    os.system('cls')
    print("++=================================================++")
    print("||                RAIL FENCE CIPHER                ||")
    print("++=================================================++\n")
    print("1. Encryption")
    print("2. Decryption\n")
    menu=input("Choose : ")
    if(menu=='1'):
        valid=False
        while(not valid):
            plaintext=input("\nPlaintext\t\t\t: ")
            check_plaintext=re.sub(r"\s+", "", plaintext)
            if(check_plaintext==""):
                print("\nPlaintext can't be empty!")
            elif(('*' in plaintext) or ('~' in plaintext)):
                print("\nYou can't use * or ~ in your string!")
            else:
                valid=True
        valid=False
        while(not valid):
            try:
                key=int(input("Key (numbers)\t\t\t: "))
                if(key<=1):
                    raise Exception()
                valid=True
            except:
                print("\nYou can only use integer larger than 1 for the key!\n")
        preserve_whitespaces=input("Preserve whitespaces? [y/n]\t: ")
        ciphertext=encrypt_rail_fence(plaintext,key,preserve_whitespaces)
        print("\nYour encrypted text is \"{}\"".format(ciphertext))
    elif(menu=='2'):
        valid=False
        while(not valid):
            ciphertext=input("\nEncrypted message\t: ")
            check_ciphertext=re.sub(r"\s+", "", ciphertext)
            if(check_ciphertext==""):
                print("\nCiphertext can't be empty!")
            elif(('*' in ciphertext) or ('~' in ciphertext)):
                print("\nYou can't use * or ~ in your string!")
            else:
                valid=True
        valid=False
        while(not valid):
            try:
                key=int(input("Key (numbers)\t\t: "))
                if(key<=1):
                    raise Exception()
                valid=True
            except:
                print("\nYou can only use integer larger than 1 for the key!\n")
        plaintext=decrypt_rail_fence(ciphertext,key)
        print("\nYour decrypted text is \"{}\"".format(plaintext))

def caesar():
    """Interface of menu 1 (Caesar Cipher)"""
    os.system('cls')
    print("++=================================================++")
    print("||                  CAESAR CIPHER                  ||")
    print("++=================================================++\n")
    print("1. Encryption")
    print("2. Decryption\n")
    menu=input("Choose : ")
    if(menu=='1'):
        valid=False
        while(not valid):
            plaintext=input("\nPlaintext\t\t\t: ")
            check_plaintext=re.sub(r"\s+", "", plaintext)
            if(check_plaintext==""):
                print("\nPlaintext can't be empty!")
            else:
                valid=True
        valid=False
        while(not valid):
            try:
                key=int(input("Key (numbers)\t\t\t: "))
                if(key==0):
                    raise Exception()
                valid=True
            except:
                print("\nYou can only use non-zero integer for the key!\n")
        preserve_whitespaces=input("Preserve whitespaces? [y/n]\t: ")
        ciphertext=encrypt_caesar(plaintext,key,preserve_whitespaces)
        print("\nYour encrypted text is \"{}\"".format(ciphertext))
    elif(menu=='2'):
        valid=False
        while(not valid):
            ciphertext=input("\nEncrypted message\t: ")
            check_ciphertext=re.sub(r"\s+", "", ciphertext)
            if(check_ciphertext==""):
                print("\nCiphertext can't be empty!")
            else:
                valid=True
        valid=False
        while(not valid):
            try:
                key=int(input("Key (numbers)\t\t: "))
                if(key==0):
                    raise Exception()
                valid=True
            except:
                print("\nYou can only use non-zero integer for the key!\n")
        plaintext=decrypt_caesar(ciphertext,key)
        print("\nYour decrypted text is \"{}\"".format(plaintext))

def super_encryption():
    """Interface of menu 3 (Super Encryption)"""
    os.system('cls')
    print("++=================================================++")
    print("||                 SUPER ENCRYPTION                ||")
    print("++=================================================++\n")
    print("1. Encryption")
    print("2. Decryption\n")
    menu=input("Choose : ")
    if(menu=='1'):
        valid=False
        while(not valid):
            plaintext=input("\nPlaintext\t\t\t\t: ")
            check_plaintext=re.sub(r"\s+", "", plaintext)
            if(check_plaintext==""):
                print("\nPlaintext can't be empty!")
            elif(('*' in plaintext) or ('~' in plaintext)):
                print("\nYou can't use * or ~ in your string!")
            else:
                valid=True
        valid=False
        while(not valid):
            v_key=input("Key for Vigenere (words/sentence)\t: ")
            check_v_key=re.sub(r"\s+", "", v_key)
            if(check_v_key==""):
                print("\nKey can't be empty!\n")
            elif(not check_v_key.isalpha()):
                print("\nYou can only use alphabet and space for the key!\n")
            else:
                valid=True
        valid=False
        while(not valid):
            try:
                rf_key=int(input("Key for Rail Fence (numbers)\t\t: "))
                if(rf_key<=1):
                    raise Exception()
                valid=True
            except:
                print("\nYou can only use integer larger than 1 for the key!\n")
        valid=False
        while(not valid):
            try:
                c_key=int(input("Key for Caesar (numbers)\t\t: "))
                if(c_key==0):
                    raise Exception()
                valid=True
            except:
                print("\nYou can only use non-zero integer for the key!\n")
        preserve_whitespaces=input("Preserve whitespaces? [y/n]\t\t: ")
        first_enc=encrypt_vigenere(plaintext,v_key,preserve_whitespaces)
        second_enc=encrypt_rail_fence(first_enc,rf_key,preserve_whitespaces)
        third_enc=encrypt_caesar(second_enc,c_key,preserve_whitespaces)
        print("\nYour encrypted text is \"{}\"".format(third_enc))
    elif(menu=='2'):
        valid=False
        while(not valid):
            ciphertext=input("\nEncrypted message\t\t\t: ")
            check_ciphertext=re.sub(r"\s+", "", ciphertext)
            if(check_ciphertext==""):
                print("\nCiphertext can't be empty!")
            elif(('*' in ciphertext) or ('~' in ciphertext)):
                print("\nYou can't use * or ~ in your string!")
            else:
                valid=True
        valid=False
        while(not valid):
            v_key=input("Key for Vigenere (words/sentence)\t: ")
            check_v_key=re.sub(r"\s+", "", v_key)
            if(check_v_key==""):
                print("\nKey can't be empty!\n")
            if(not check_v_key.isalpha()):
                print("\nYou can only use alphabet and space for the key!\n")
            else:
                valid=True
        valid=False
        while(not valid):
            try:
                rf_key=int(input("Key for Railfence (numbers)\t\t: "))
                if(rf_key<=1):
                    raise Exception()
                valid=True
            except:
                print("\nYou can only use integer larger than 1 for the key!\n")
        valid=False
        while(not valid):
            try:
                c_key=int(input("Key for Caesar (numbers)\t\t: "))
                if(c_key==0):
                    raise Exception()
                valid=True
            except:
                print("\nYou can only use non-zero integer for the key!\n")
        first_dec=decrypt_caesar(ciphertext,c_key)
        second_dec=decrypt_rail_fence(first_dec,rf_key)
        third_dec=decrypt_vigenere(second_dec,v_key)
        print("\nYour decrypted text is \"{}\"".format(third_dec))

back='Y'
while(back.upper()=='Y'):
    os.system('cls')
    print("++=================================================++")
    print("||        ENCRYPTION AND DECRYPTION PROGRAM        ||")
    print("++=================================================++\n")
    print("1. Vigenere Cipher")
    print("2. Railfence Cipher")
    print("3. Caesar Cipher")
    print("4. Super Encryption (Combination of menu 1, 2, and 3)\n")
    menu=input("Choose : ")
    print()
    if(menu=='1'):
        vigenere()
    elif(menu=='2'):
        rail_fence()
    elif(menu=='3'):
        caesar()
    elif(menu=='4'):
        super_encryption()
    else:
        print("Sorry, this menu doesn't exist!")
    back=input("\nBack to menu? [y/n] : ")
    print()
