try:
    from PIL import Image
    import numpy as np
    import tensorflow as tf
    import pymysql
    import re
    conn = pymysql.connect(host='39.107.39.25', port=3306, user='root', password='acEI3iEqsJEEsXQQ',database='CPTJ',charset="utf8")
    curs = conn.cursor()
    sql = "select path from img"
    row=""
    try:
        curs.execute(sql)  # 执行sql语句
        res = curs.fetchall()  # 获取查询的所有记录
        curs.close()
        conn.close()
        for rows in res:
            row=rows
    except Exception as e:
        raise e
    p=re.compile(r"'(.+)'",re.M)
    row=p.findall(str(row))

    Vegetable_Model = tf.keras.models.load_model('../model/vegetable_model(5.5.5.1).h5')
    x=Image.open(row[0])
    x=x.resize((256,256))
    x=np.array(x)
    c=[]
    c.append(x)
    c=np.array(c)
    y=Vegetable_Model.predict(c)
    count=0
    for i in np.nditer(y):
        if i==1:
            break
        count+=1
    conn = pymysql.connect(host='39.107.39.25', port=3306, user='root', password='acEI3iEqsJEEsXQQ', database='CPTJ',
                           charset="utf8")
    curs = conn.cursor()
    sql = "UPDATE img SET result = "+str(count)+" WHERE path="+'"'+row[0]+'"'
    try:
        curs.execute(sql)
        conn.commit()
        curs.close()
        conn.close()
    except Exception as e:
        print(e)
        conn.rollback()  # 发生错误时回滚
except Exception as e:
    print(e)
