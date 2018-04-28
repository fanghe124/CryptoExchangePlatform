import sqlite3
import pandas as pd

class Portable:

    def __init__(self, table=0):
        ##derault table is 0
        self.table = "portable_" + str(table)
        self.conn = sqlite3.connect("portable.db")       
        self.c = self.conn.cursor()
        self.connect(self.c, self.table)

        
    ## connect to database. default 0
    def connect(self, c, table):
        try:
            self.c.execute('''CREATE TABLE if NOT EXISTS {}
                     (key, value blob)'''.format(table))
            return True
        except Exception as e:
            print(e)
            return False

        

    ##close database
    def close(self):
        return self.conn.close()
        

    ##select database (default 0)
    def select(self, database="0"):
        pass

    ##set data on database with (key, value)
    def set(self, key, value):
        if self.if_exists(key):
            self.rm(key)
        try:
            self.c.execute("""INSERT INTO {}(key, value) VALUES('{}','{}')""".format(self.table, str(key), value))
            self.conn.commit()
        except Exception as e:
            print(e)
            return False
        return True


    ##get the data (key)
    def get(self, key):
        try:
            query = """SELECT * FROM {} WHERE key='{}'""".format(self.table, key)
            self.c.execute(query)
            all_data = self.c.fetchall()[0][1]
        except Exception as e:
            print(e)
            return False
        return all_data
    

    ##dump all keys
    def keys(self):
        query = """SELECT * FROM {}""".format(self.table)
        self.c.execute(query)
        result = list(i[0] for i in self.c.fetchall())
        return result
    
    ##check if key is exist
    def if_exists(self, key):
        query = """SELECT EXISTS(SELECT * FROM {} WHERE key="{}");""".format(self.table, key)
        self.c.execute(query)
        result = self.c.fetchall()[0][0] == True
        return result
         
    ##delete key
    def rm(self, key):
        try:
            query = """DELETE FROM {} WHERE key='{}'""".format(self.table, key)
            self.c.execute(query)
            self.conn.commit()
        except Exception as e:
            print(e)
        
    ##search key
    def search(self, key):
        query = """SELECT * FROM {}""".format(self.table)
        self.c.execute(query)
        dic = {}
        for i in self.c.fetchall():
            dic.update({i[0]:i[1]})
        result = list(k for k,v in dic.items() if key in k.lower())
        return result

        
    ##delete all database
    def flushall(self):
        try:
            query = """DROP TABLE {}""".format(self.table)
            self.c.execute(query)
            self.conn.commit()
            self.connect(self.c, self.table)
            print("All data will be deleted")
            return True
        except Exception as e:
            print(e)
            return False



if __name__=="__main__":
    redis = Portable(0)

    




