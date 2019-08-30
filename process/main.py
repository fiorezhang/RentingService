# coding:utf-8
# main.py

from detect import *
from clean import *
from load import *

if __name__ == '__main__':
    filesAdd = detectNewFiles(PATH_TO_DETECT, NEW_FILE_TO_RECORD)
    print(filesAdd)
    classifyByCompany(filesAdd, PATH_TEMP_WORK)
    cleanByFilters(filesAdd, PATH_TEMP_WORK)
    importData(filesAdd, PATH_TEMP_WORK)
    recordFileList(PATH_TO_DETECT, NEW_FILE_TO_RECORD)

