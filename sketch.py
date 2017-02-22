
from numpy import zeros, random, dot#, array, matrix

def sketch(M, k):
    # matrix height and width
    # M = matrix(M)
    # change width and height
    # w,h = M.shape
    w = len(M)
    h = len(M[0])

    # generating k random directions simply use vectors of normally distributed random numbers
    rd = random.randn(k, h)
    # init sketches
    sketches = zeros((k, w))
    for i in range(k):
        for j in range(w):
            # v = dot(rd[i], M[j, :])
            v = dot(rd[i], M[j])
            sketch = 1
            if v > 0:
                sketch = 1
            elif v < 0:
                sketch = -1
            # v == 0 is of a tiny probability and we can choose +1 or -1 randomly
            else:
                if random.random() >= 0.5:
                    sketch = 1
                else:
                    sketch = -1
            sketches[i][j] = sketch
    return sketches