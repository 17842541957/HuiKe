import time
import os
import requests
import re
headers = {
    "User-Agent" : "addasdsd"
}
for i in range(1,2):
    x = "https://www.hellorf.com/image/search-graph?file=zJDM48FzcLuyPCHAZ2QY5w%253D%253D"#+str(i)
    response = requests.get(x,headers=headers)
    #print(response.request.headers)
    html = response.text

    dir_name = "dabaicai"
    if not os.path.exists(dir_name):
        os.mkdir(dir_name)

    urls = re.findall('<img data-src="(.*?)" class=".*?" alt=""/>',html)
    #print(urls)
    print(len(urls))
    for url in urls:
        print(url)
        time.sleep(0.3)
        file_name = url.split('/')[-1]
        response = requests.get(url,headers=headers)
        with open(dir_name + '/' + file_name,'wb') as f:
            f.write(response.content)
