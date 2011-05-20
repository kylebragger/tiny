"""
Tiny

A reversible base62 ID obfuscater

Authors:
    Jacob DeHart (original PHP version) and Kyle Bragger (Ruby port)
    and Lee Semel (python port)

Usage:
    obfuscated_id = to_tiny(123)
    original_id = from_tiny(obfuscated_id)

Configuration:
    You must run generate_set() from console (using python tiny.py) to generate your $set
    Do *not* change this once you start using Tiny, as you won't be able to from_tiny()
    any values to_tiny()'ed with another set.

"""
import random

SET = 'poygezRY9L1x8CTl6rUBKQHwVuIkh4fZ7cv3sdJaAjO2iqWbFt0nM5EPGSmDXN'

def to_tiny(id):
    """Converts from an integer to a tinified string."""
    id = int(id)
    hexn = ""
    radix = len(SET)
    while(True):
        r = id % radix
        hexn = SET[r] + hexn
        id = (id - r) / radix
        if (id == 0):
            break
    return hexn
    
def from_tiny(s):
    """Converts from a tinified string to an integer.
    
    If any illegal characters are used in the string, return a -1.  
    These tiny urls are almost always used to look up a database item by
    primary key, so this ensures that the database item is not found,
    and a normal 404 page is thrown.  If we instead threw an exception
    we'd have a different exception to handle and the normal 404 page would
    not be shown.
    
    >>> from_tiny('abc_')
    -1
    >>> from_tiny('!!#$#$')
    -1
    >>> from_tiny('')
    0
    
    """
    radix = len(SET)
    strlen = len(s)
    n = 0
    i = 0
    while (i < strlen):
        p = SET.find(s[i])
        if (p < 0):
            return -1
        c = p * pow(radix, strlen - i - 1)
        n += c
        i += 1
    return n
    
def generate_set():
    """Generates a new random set to be used for encoding.
    
    The set will contain the uppercase and lowercase letters a-z and digits 0-9.
    
    >>> set = generate_set()
    >>> len(set)
    62
    >>> ok = True
    >>> seen = {}
    >>> "".join(sorted(set))
    '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
    >>> for i in range(0,100000):
    ...   t = to_tiny(i)
    ...   if (t in seen or len(t) == 0):
    ...       ok = False
    ...   seen[t] = i
    ...   f = from_tiny(t)
    ...   if (f != i): 
    ...       ok = False
    ... 
    >>> ok
    True
    """
    arr = []
    for i in range(0,10):
        arr.append(str(i))
    for i in range(65,123):
        if i < 91 or i > 96:
             arr.append(chr(i))
    random.shuffle(arr)
    return "".join(arr)
    
if __name__=="__main__":
    import doctest
    doctest.testmod()
    print(generate_set())
    

