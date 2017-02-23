'''
Project: Prism
Author: Kain Liu
'''

from PIL import Image
from cossim import cossim
from sketch import sketch
from numpy import *
import time
import os, sys
import scipy.spatial.distance as dis


# 24k pictures in total
population = 24000

# random vector
rv_number = 256

# sample id of images
samples = [ 2158,  7418, 7757, 9824, 22039, 
            16336, 7463, 4595, 20159, 17348, 
            19166, 23112, 16678,  2084, 11398, 
            19557, 14867,  5437, 13122, 20811]


'''
Generate a signature based on colour information
'''
def color_sig(file, seg = 4):
    print file
    try:
        im = Image.open(file)
        print(im.format, im.size, im.mode)
    except:
        print "Unable to load image!"

    w, h = im.size
    colors = im.getcolors(w*h)


    color_counter = {}

    def cut(x, n=16):
        return x / (256 / n)

    for color in colors:
        key = []
        for x in color[1]:
            key.append(cut(x, seg))
        key = str(key)
        color_counter.setdefault(key, []).append(color[0])


    hash_result = []

    # loop throught rgb colors
    for r in range(0, seg):
        for g in range(0, seg):
            for b in range(0, seg):
                key = str([r, g, b])
                if key in color_counter:
                    val = sum(color_counter[key])
                else:
                    val = 0

                # optional: ignore background color which is black
                '''
                if r == 0 and g == 0 and b == 0:
                    val = 0
                '''

                # optional: ignore the color takes up too much weight
                '''
                if val > 10000:
                    val = 0
                '''

                hash_result.append(val)

    return hash_result



'''
calculate which size is the best choice for bins
'''
def bin_size():
    for i in (2, 4, 8, 16, 32, 64):
        # compare image collections of two objects
        a1 = color_sig('dataset/251_l3c1.png', i)
        a2 = color_sig('dataset/251_l3c2.png', i)
        a3 = color_sig('dataset/251_l3c3.png', i)
        b1 = color_sig('dataset/255_l3c1.png', i)
        b2 = color_sig('dataset/255_l3c2.png', i)
        b3 = color_sig('dataset/255_l3c3.png', i)

        # generate a latex table
        print "====== i:", i, " ======"
        print '& $A_1$ &',cossim_3(a1, a1), '&',cossim_3(a1, a2), '&',cossim_3(a1, a3), '&',cossim_3(a1, b1), '&',cossim_3(a1, b2), '&',cossim_3(a1, b3), '\\\\ \cline{2-8}'
        print '& $A_2$ &',cossim_3(a2, a1), '&',cossim_3(a2, a2), '&',cossim_3(a2, a3), '&',cossim_3(a2, b1), '&',cossim_3(a2, b2), '&',cossim_3(a2, b3), '\\\\ \cline{2-8}'
        print '& $A_3$ &',cossim_3(a3, a1), '&',cossim_3(a3, a2), '&',cossim_3(a3, a3), '&',cossim_3(a3, b1), '&',cossim_3(a3, b2), '&',cossim_3(a3, b3), '\\\\ \cline{2-8}'
        print '& $B_1$ &',cossim_3(b1, a1), '&',cossim_3(b1, a2), '&',cossim_3(b1, a3), '&',cossim_3(b1, b1), '&',cossim_3(b1, b2), '&',cossim_3(b1, b3), '\\\\ \cline{2-8}'
        print '& $B_2$ &',cossim_3(b2, a1), '&',cossim_3(b2, a2), '&',cossim_3(b2, a3), '&',cossim_3(b2, b1), '&',cossim_3(b2, b2), '&',cossim_3(b2, b3), '\\\\ \cline{2-8}'
        print '& $B_3$ &',cossim_3(b3, a1), '&',cossim_3(b3, a2), '&',cossim_3(b3, a3), '&',cossim_3(b3, b1), '&',cossim_3(b3, b2), '&',cossim_3(b3, b3), '\\\\ \cline{2-8}'


def sig(start = 1, end = 1000):
    file = open("result/sig.txt", "w")
    t0 = time.clock()

    for i in range(start, end + 1):
        for j in range(1, 9):
            for k in range(1, 4):
                h = color_sig(id2path(i, j, k))
                file.write(str(h).replace(",","").replace("[","").replace("]",""))
                file.write("\n")
        print "{0} of {1}".format(i, end - start + 1)

    file.close()
    print "sig.txt finish."
    print time.clock() - t0, "seconds in generating signatures"



def matrix():

    t0 = time.clock()
    sketches = open_sketch()

    # sketch has #vectors rows and #image columns
    # every row is result multipied by one random vector
    result = dot(sketches.transpose(), sketches)

    # save result
    print time.clock() - t0, "seconds in generating matrix"

    m = zeros([len(samples), population])

    for i in range(len(samples)):
        m[i] =  result[samples[i]]
    savetxt('result/matrix-sample.txt', m, fmt='%i')

def cos():
    sig = open_sig()
    s = zeros([len(samples), population])
    for i in range(len(samples)):
        for j in range(0, population):
            s[i][j] =  cossim_3(sig[samples[i]], sig[j])
    savetxt('result/similarity-sample.txt', s, fmt='%.3f')




def sketch():
    t0 = time.clock()
    m = open_sig()
    print "signature matrix size is {0} x {1}".format(m.shape[0], m.shape[1])
    sketches = sketch(m, rv_number)
    print "sketch matrix size is {0} x {1}".format(sketches.shape[0], sketches.shape[1])
    print time.clock() - t0, "seconds in generating sketches"
    savetxt('result/sketch.txt', sketches, fmt='%d')



def similar(i, j, k):

    # only calculate all pairs of given image with rest images
    line = id2line(i, j, k)
    sketches = open_sketch()

    t0 = time.clock()

    '''
    def nested_loop(sketches):
        h = len(sketches)
        w = len(sketches[0])
        _r = []
        for i in range(0, w):
            intersection = 0
            for k in range(0, h):
                if sketches[k][i] == sketches[k][line]:
                        intersection += 1
            _r.append(round(
                float(intersection) / float(w),
                4
            ))
        return _r
    
    pre_sim = nested_loop(sketches)
    '''
    
    def transpose_dot(sketches):
        result = dot(sketches.transpose()[line], sketches)
        return result
    pre_sim = transpose_dot(sketches)

    # get top n
    # argsort(line)[-n:] #last n elements
    # [::-1] # reverse
    n = 32
    top_n = argsort(pre_sim)[-n:][::-1]
    result = []
    path = []
    for top in top_n:
        di = line2id(top)
        result.append( di )
        path.append( id2path(di[0],di[1],di[2]) )

    print time.clock() - t0, "seconds in finding similar items"
    print result
   

def similar_all():

    def transpose_dot(_sketches, _line):
        result = dot(_sketches.transpose()[_line], _sketches)
        return result

    # only calculate all pairs of given image with rest images
    file = open("result/all-to-mongodb.txt", "w")

    sketches = open_sketch()

    t00 = time.clock()
    for i in range(0, population):

        t0 = time.clock()
        pre_sim = transpose_dot(sketches, i)

        # get top n
        # argsort(line)[-n:] #last n elements
        # [::-1] # reverse
        n = 32
        top_n = argsort(pre_sim)[-n:][::-1]
        result = []
        path = []
        for top in top_n:
            di = line2id(top)
            result.append( di )
            path.append( id2path(di[0],di[1],di[2]) )

        print i, ' : ', time.clock() - t0, "s"
        # print result

        # Mongodb insert similar neighbors for each picture
        # print(i, path)
        file.write("db.similarPic.insert({{ id: {} , neighbors: {} }})".format(i, path))
        file.write("\n")
    print "Total {}s".format(time.clock() - t00)
    file.close()

'''
loader functions
'''

def open_sig():
    t0 = time.clock()
    m = loadtxt("result/sig.txt")
    print time.clock() - t0, "seconds in opening signatures"
    return m
    
# def open_matrix():
#     t0 = time.clock()
#     m = loadtxt("('result/matrix.txt")
#     print time.clock() - t0, "seconds in opening signatures"
#     return m.shape

def open_sketch():
    t0 = time.clock()
    m = loadtxt("result/sketch.txt")
    print time.clock() - t0, "seconds in opening sketches"
    return m


'''
helper functions
'''

def id2path(i, j, k):
    return "dataset/{0}/{0}_l{1}c{2}.png".format(i, j, k)

def id2line(i, j, k):
    line = (i - 1) * 24 + (j - 1) * 3 + (k - 1)
    return line

def line2id(line):
    a = line / 24 + 1
    b = line % 24 / 3 + 1
    c = line % 24 % 3 + 1
    return a, b, c

def cossim_3(x, y):
    return round(cossim(x, y), 3)

'''
main function
'''
if __name__ == "__main__":

    c = sys.argv[1] if len(sys.argv) > 1 else ""

    if c == "sig":
        sig()

    elif c == "sketch":
        if len(sys.argv) > 2:
            rv = int(sys.argv[2])
        else:
            rv = 256
        print 'INFO: ', rv, ' random vectors'
        sketch(rv)

    elif c == "cos":
        cos()

    elif c == "matrix":
        matrix()

    elif c == "similar":
        if len(sys.argv) > 4:
            similar(
                int(sys.argv[2]),
                int(sys.argv[3]),
                int(sys.argv[4])
            )
        else:
            print 'ERROR: Please identify the picture id.'

    elif c == "all":
        similar_all()

    elif c == 'lsh':
        lsh_all()

    elif c == 'bin_size':
        bin_size()

    else:
        print '''
        
    Welcome to Prism.

    Options:

    * sig       : generate Signatures based on the colours distribution.
    * sketch    : generate Sketches based on Signatures.
    * cos       : calculate the Cosine Similarity between samples and all population.
    * matrix    : calculate the similarity matrix based on Sketeches
    * similar   : find similar candidates for one image
    * all       : find similar candidates for all images, generate a mongdb sql as output
    * bin_size  : experiments to optimize bin size

        '''
