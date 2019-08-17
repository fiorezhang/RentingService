# -*- coding:utf-8 -*-
import os
import time

path_to_detect = r'.\test'
file_to_record = r'.\record.txt'

def saveFile(content, fileName):
    try:
        f = open(fileName,"wb")
        f.write(content.encode('utf-8'))
        f.close()
        return True
    except Exception as e:
        print(e)
        return False
        
def loadFile(fileName):
    try:
        f = open(fileName, "rb")
        content = f.read().decode('utf-8')
        f.close()
        return content
    except Exception as e:
        print(e)
        return None

def getFileList(path):
    fileList = []
    for root, dirs, files in os.walk(path):
        for file in files:
            fileList.append(os.path.join(root,file))
    return fileList

def detectNewFiles(path, record):
    with open(record, "r", encoding='UTF-8') as f:
        filesOld = f.read().splitlines()
        filesNew = getFileList(path)
        #print(filesOld)
        #print('-'*100)
        #print(filesNew)
        filesAdd = [file for file in filesNew if not file in filesOld]
        return filesAdd

def recordFileList(path, record):
    with open(record, "w", encoding='utf-8') as f:
        filesNew = getFileList(path)
        f.writelines([file+'\n' for file in filesNew])

if __name__ == '__main__':
    #recordFileList(path_to_detect, file_to_record)
    filesAdd = detectNewFiles(path_to_detect, file_to_record)
    print(filesAdd)

'''
before = dict ([(f, None) for f in os.listdir (path_to_watch)])
while 1:
    time.sleep (10)
    after = dict ([(f, None) for f in os.listdir (path_to_watch)])
    added = [f for f in after if not f in before]
    removed = [f for f in before if not f in after]
    if added: print "Added: ", ", ".join (added)
    if removed: print "Removed: ", ", ".join (removed)
    before = after
'''