#coding: utf-8

import os
import shutil
import platform
import re

from config import *


#创建新目录
def mkdir(path):
    path = path.strip()
    # 判断路径是否存在
    # 存在     True
    # 不存在   False
    isExists=os.path.exists(path)
    #print(isExists)
    # 判断结果
    if not isExists:
        # 如果不存在则创建目录
        # 创建目录操作函数
        os.makedirs(path)
        return True
    else:
        # 如果目录存在则不创建，并提示目录已存在
        return False     

#删除目录
def rmdir(path):
    shutil.rmtree(path)

#处理原始数据
def replaceByFilter(line, file):
    company = os.path.splitext(file)[0]
    items = line.split('\t')
    if (len(items) != 38): #如果原始数据不是38项，就打印报错并舍去原始数据
        print("WARNING")
        print(len(items))
        print(items)
        return ""
    else:
        #sVisitDate sVisitTime 数据拆分成两项
        if '-' in items[6] and ':' in items[6]:
            items[6] = re.sub(' ', '\t', items[6])
        else:
            items[6] = 'NULL\tNULL'
        #sVProvince
        if '省' in items[7]:
            items[7] = re.sub('省', '', items[7])
        #sVCity
        if '市' in items[8]:
            items[8] = re.sub('市', '', items[8])
        #sVRegion
        if '区' in items[9]:
            items[9] = re.sub('区', '', items[9])
        #sFloor
        if '层' in items[17]:
            items[17] = re.sub('层', '', items[17])
        #sBestTime不属于原始数据，把NULL设做默认值加到sIdfa之后
        if '\n' in items[-1]:
            items[-1] = re.sub('\n', '\tNULL\n', items[-1])
    try: 
        ret = '\t'.join([items[i] for i in range(len(items))])
        return ret
    except Exception as e:
        print(e)        
        return ""
    
#按公司名把原始数据拆分，因为不同公司的数据格式略有不同
def classifyByCompany(list_files, folder_work):
    for fileSource in list_files:
        #print(fileSource)
        folder = os.path.splitext(fileSource)[0]
        folder = re.sub(r"\/", r"_", folder)
        #print(folder)
        if mkdir(folder_work+os.sep+folder): #工作目录下为每一个原始数据建立一个同名目录
            #TODO: 应加入出错监测机制，如果出错则删掉当前目录
            mkdir(folder_work+os.sep+folder+os.sep+FOLDER_ORIGINAL) #该同名目录下，建立一个子目录，存放按公司名分类的原始数据
            with open(fileSource, "r", encoding='UTF-8') as fS:
                lines = ""
                companyLast = None
                for line in fS.readlines():
                    items = line.split('\t', 2)
                    if len(items)>=2:
                        #公司名在第二列
                        company = items[1]
                        #print(company)
                        #如果公司名没有在名单里，更新名单（主要是方便统计）
                        if company not in LIST_COMPANY_NAME:
                            LIST_COMPANY_NAME.append(company)
                        #如果当前行和上一行是一个公司，把当前行的内容加入缓存（lines）；如果换了一个公司，把前一个公司的缓存内容一次性写入，然后开始缓存当前公司内容
                        if company == companyLast:
                            lines += line
                        else:
                            if companyLast != None: #针对第一行，不写缓存，其它时候都要先写缓存
                                with open(folder_work+os.sep+folder+os.sep+FOLDER_ORIGINAL+os.sep+companyLast+".txt", "a+", encoding='UTF-8') as fW:
                                    fW.write(lines)
                            #再从当前行内容开始更新缓存，更新记录的上一个公司名
                            lines = line
                            companyLast = company
                #退出行的遍历后，最后一次的缓存也要写入            
                with open(folder_work+os.sep+folder+os.sep+FOLDER_ORIGINAL+os.sep+companyLast+".txt", "a+", encoding='UTF-8') as fW:
                    fW.write(lines)
    print(LIST_COMPANY_NAME)

def cleanByFilters(list_files, folder_work):
    for fileSource in list_files:
        dirWork = os.path.splitext(fileSource)[0]
        dirWork = re.sub(r"\/", r"_", dirWork)
        if dirWork in os.listdir(folder_work):
            mkdir(folder_work+os.sep+dirWork+os.sep+FOLDER_CLEAN) #该同名目录下，建立一个子目录，存放按公司名分类的清洗后数据，有可能这个目录已经存在了
            for file in os.listdir(folder_work+os.sep+dirWork+os.sep+FOLDER_CLEAN):
                if os.path.splitext(file)[1] == TAG_UNFINISH:
                    print('REMOVE '+file)
                    os.remove(folder_work+os.sep+dirWork+os.sep+FOLDER_CLEAN+os.sep+file)
            for file in os.listdir(folder_work+os.sep+dirWork+os.sep+FOLDER_ORIGINAL):
                print('-'*10 + file)
                if os.path.exists(folder_work+os.sep+dirWork+os.sep+FOLDER_CLEAN+os.sep+file): #避免重复写入相同数据
                    print('-- EXIST')
                else:
                    lines = ""
                    with open(folder_work+os.sep+dirWork+os.sep+FOLDER_ORIGINAL+os.sep+file, "r", encoding='UTF-8') as fO:
                        linesRead = fO.readlines()
                        linesWrite = ""
                        for i in range(len(linesRead)):
                            linesWrite += replaceByFilter(linesRead[i], file) #调用函数，将一行原始数据传入，根据文件名（公司名）在函数内做筛选，输出精简后的一行数据
                            if i%10000 == 0 and linesWrite != "":     #每一行都写入效率太低，隔一段写一次，循环数表示每次缓存的行数
                                print('.', end='')
                                with open(folder_work+os.sep+dirWork+os.sep+FOLDER_CLEAN+os.sep+file+TAG_UNFINISH, "a+", encoding='UTF-8') as fC:
                                    fC.write(linesWrite)
                                linesWrite = ""
                        if linesWrite != "":   #写完最后一笔  
                            print('.', end='')
                            with open(folder_work+os.sep+dirWork+os.sep+FOLDER_CLEAN+os.sep+file+TAG_UNFINISH, "a+", encoding='UTF-8') as fC:
                                fC.write(linesWrite)
                        #在写入完成前文件名加unfinish后缀，完成后才改成正式名
                        if os.path.exists(folder_work+os.sep+dirWork+os.sep+FOLDER_CLEAN+os.sep+file+TAG_UNFINISH):
                            print('')        
                            os.rename(folder_work+os.sep+dirWork+os.sep+FOLDER_CLEAN+os.sep+file+TAG_UNFINISH, folder_work+os.sep+dirWork+os.sep+FOLDER_CLEAN+os.sep+file)    
                        else: #处理出错（比如公司名不在list内）
                            print('@@ ERROR')
                        
# --MAIN--    
if __name__ == "__main__":
    classifyByCompany([], PATH_TEMP_WORK)    
    cleanByFilters([], PATH_TEMP_WORK)
