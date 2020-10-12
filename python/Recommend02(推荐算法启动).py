import pymysql
import numpy as np
import sys

def data_get():
	conn = pymysql.connect(host='39.107.39.25', port=3306, user='root', password='acEI3iEqsJEEsXQQ',database='CPTJ',charset="utf8")
	curs_data = conn.cursor()
	sql_data = "select * from `like`"
	try:
		curs_data.execute(sql_data)  # 执行sql语句
		data_re = curs_data.fetchall()  # 获取查询的所有记录
		curs_data.close()
		conn.close()
	except Exception as e:
		raise e




	data=[]
	ks=[]
	id_list=[]
	user_name=[]
	for x in data_re:
		for c in x:
			ks.append(c)
		id_list.append(ks[0])
		user_name.append(ks[1])
		del ks[0]
		del ks[0]
		data.append(ks)
		ks=[]
	data=np.mat(data)
	id_list=np.array(id_list)-1
	return data,user_name,id_list


def cos_sim(x, y):
    """余弦相似性

    Args:
    - x: mat, 以行向量的形式存储
    - y: mat, 以行向量的形式存储

    :return: x 和 y 之间的余弦相似度
    """
    numerator = x * y.T  # x 和 y 之间的内积
    denominator = np.sqrt(x * x.T) * np.sqrt(y * y.T)
    return (numerator / denominator)[0, 0]
    
    
def similarity(data):
    """计算矩阵中任意两行之间的相似度
    Args:
    - data: mat, 任意矩阵

    :return: w, mat, 任意两行之间的相似度
    """

    m = np.shape(data)[0]  # 用户的数量
    # 初始化相似矩阵
    w = np.mat(np.zeros((m, m)))

    for i in range(m):
        for j in range(i, m):
            if not j == i:
                # 计算任意两行之间的相似度
                w[i, j] = cos_sim(data[i], data[j])
                w[j, i] = w[i, j]
            else:
                w[i, j] = 0
    return w
    
    
def similarity_clern_data(w):
    """w用户相似度矩阵"""
    w=np.array(w)
    k=0
    s=0
    for i in w:
        for j in i:
            if j ==0:
                w[k][s]=1
            s+=1
        k+=1
        s=0
    return w

def user_index(user_name_list,user_name):
	index=user_name_list.index(user_name)
	return index


"""
w=similarity(data)#相似度矩阵
w=similarity_clern_data(w)#数据清洗
user_like = np.argmin(w[1])#最相似用户
tuijian=np.argmax(data[user_like])#推荐品
"""

if __name__ == "__main__":
	data,user_name_list,id_list=data_get()#数据获取
	w=similarity(data)
	w=similarity_clern_data(w)#相似度矩阵
	user_name_get=sys.argv[1]
	index=user_index(user_name_list,user_name_get)
	user_like=np.argmin(w[index])
	recommend=np.argmax(data[user_like])
	print(recommend)
