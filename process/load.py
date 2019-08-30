#coding: utf-8

import os
import platform
import pymysql
import csv
import codecs
import re

from config import *


def readCsvToSql(filename, database, table):
    with codecs.open(filename=filename, mode='r', encoding='utf-8') as f:
        reader = csv.reader(f, delimiter='\t')
        #head = next(reader) #没有head行
        conn = pymysql.connect(host='localhost', port=3306, user=USER, passwd=PSWD, db=database, charset='utf8')
        cur = conn.cursor()
        sql = 'insert into '+table+' values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)'
        for item in reader:
            #if item[1] is None or item[1] == '':  # item[1]作为唯一键，不能为null
            #    continue
            args = tuple(item)
            #print(len(args))
            #设置两次重试，如果没有问题直接跳出，如果第一次出错，极可能1406字符串过长，尝试裁剪重试，如果再次出错，放弃这一行
            retry = 2
            while retry:
                try:
                    cur.execute(sql, args)
                    break #没有错误就break，完成当前数据的处理流程
                except Exception as e:
                    #打印错误
                    print(e)
                    print(args)
                    #尝试修复 1：把原始数据长度裁剪到表格限定长度
                    item = [item[i][:VARCHAR_MAX] for i in range(len(item))]
                    args = tuple(item)
                retry -= 1

        conn.commit()
        cur.close()
        conn.close()

def importData(list_files, folder_work):
    for fileSource in list_files:
        dirWork = os.path.splitext(fileSource)[0]
        dirWork = re.sub(r"\/", r"_", dirWork)
        if dirWork in os.listdir(folder_work):
            print(dirWork)
            for file in os.listdir(folder_work+os.sep+dirWork+os.sep+FOLDER_CLEAN):
                print('-'*10+file)
                readCsvToSql(folder_work+os.sep+dirWork+os.sep+FOLDER_CLEAN+os.sep+file, DATABASE, TABLE)

if __name__ == '__main__':
    importData([], PATH_TEMP_WORK)


#附上SQL创建表格的代码，需要在执行导入python脚本之前创建好表    
'''
CREATE DATABASE IF NOT EXISTS `RENTING`;
USE RENTING;
#DROP TABLE `full`;
CREATE TABLE IF NOT EXISTS `full`(
	`company`    varchar(40),
    `class`      varchar(40),
    `date`       varchar(40),
    `time`       varchar(40),
    `province`   varchar(40),
    `city`       varchar(40),
    `district`   varchar(40),
    `community`  varchar(40),
    `money`      varchar(40),
    `room`       varchar(40),
    `area`       varchar(40),
    `direction`  varchar(40),
    `floor`      varchar(40),
    `decoration` varchar(40),
    `old`        varchar(40)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
SELECT * FROM `full` LIMIT 100;
SELECT COUNT(*) FROM `full`;
SELECT COUNT(*) FROM `full` WHERE `money` != 'NULL';
SELECT `class`, COUNT(*) AS `count_class` FROM `full` GROUP BY `class` ORDER BY `count_class` DESC;
SELECT `company`, COUNT(*) AS `count_company` FROM `full` GROUP BY `company` ORDER BY `count_company` DESC;
SELECT `province`, COUNT(*) AS `count_province` FROM `full` GROUP BY `province` ORDER BY `count_province` DESC;
SELECT `city`, COUNT(*) AS `count_city` FROM `full` GROUP BY `city` ORDER BY `count_city` DESC;
SELECT `district`, COUNT(*) AS `count_district` FROM `full` WHERE `district` != 'NULL' GROUP BY `district` ORDER BY `count_district` DESC LIMIT 100;
SELECT `money`, COUNT(*) AS `count_money` FROM `full` WHERE `money` != 'NULL' AND `money` != 'NOVA' GROUP BY `money` ORDER BY `money` DESC LIMIT 100;
'''    
