import pymysql
import json

class Portable:

    def __init__(self, table=0):
        ##derault table is 0
        self.table = "crypto_" + str(table)
        host = "localhost"
        userdb = "root"
        passdb = ""
        database = "test"
        port = 3306
        try:
            self.conn = pymysql.connect(host=host, port=port, user=userdb, passwd=passdb, db=database)
            print("Connected to table : " + str(table))
            self.connect()
        except Exception as e :
            print(e)
        pass

        
    ## connect to database. default 0
    ##{id, coin, usd_price, btc_value,  marketcap, history:[ date, open, high, low, close, volume],}
    def connect(self):
        cursor = self.conn.cursor()
        if self.show_table() == True:
##            print("table exist")
            return True
        else:
            try:
                qry = '''CREATE TABLE IF NOT EXISTS {} (key_ TEXT,value_ LONGTEXT)'''.format(self.table)            
                cursor.execute(qry)
                self.conn.commit()
                return True
            except Exception as e:
                print(e)
                return False

    def show_table(self):
        qry = """SHOW TABLES LIKE '{}'""".format(self.table)
        cursor = self.conn.cursor()
        cursor.execute(qry)
        if cursor.fetchone():
            return True
        return False

    ##close database
    def close(self):
        return self.conn.close()
        

    ##set data on database with (key, value)
    def set(self, key="BTC", value=[1,2,3,4,5]):
        
        try:
            if self.if_exists(key) == True:
                qry = """UPDATE {tbl} SET value_ = '{v}' WHERE key_= '{k}'""" .format(tbl=self.table, k=key, v=json.dumps(value))
                cursor = self.conn.cursor()
                cursor.execute(qry)
                self.conn.commit()
                return True
            else:
                qry = """INSERT INTO {tbl}
                       (key_, value_) VALUES 
                       ('{key}','{value}')""".format(tbl=self.table, key=key, value=json.dumps(value))
                cursor = self.conn.cursor()
                cursor.execute(qry)
                self.conn.commit()
                return True
        except Exception as e:
            print(e)
            return False


    ##get the data (key)
    def get(self, key):
        try:
            qry = """SELECT * FROM {tbl} WHERE key_='{key}'""".format(tbl=self.table, key=key)
            cursor = self.conn.cursor()
            cursor.execute(qry)
            result = cursor.fetchone()[1]
            return result
        except Exception as e:
            print(e)
            return False
    

    ##dump all keys
    def keys(self):
        qry = """SELECT * FROM {}  """.format(self.table)
        cursor = self.conn.cursor()
        cursor.execute(qry)
        result = cursor.fetchall()
        keys = [key[0] for key in result]       
        return keys
    
    ##check if key is exist
    def if_exists(self, key):
        qry = """SELECT * FROM {} WHERE key_='{key}'""".format(self.table, key=key)
        cursor = self.conn.cursor()
        cursor.execute(qry)
        result = cursor.fetchall()
        if len(result) > 0:
            if result[0][0] == key:
                return True
        return False
         
    ##delete key
    def rm(self, key):
        pass
        
    ##search key
    def search(self, key):
        pass

    ##delete table
    def flushall(self):
        qry = """DROP TABLE IF EXISTS {}""".format(self.table)
        try:
            cursor = self.conn.cursor()
            cursor.execute(qry)
            self.conn.commit()
            return True
        except Exception as e:
            print(e)
            return False

if __name__=="__main__":
    p = Portable(0)
    p.set("BTC",'[1,2,3]')
   
    




