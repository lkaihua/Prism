from numpy import dot, pi, arccos, allclose, linalg, random

def cossim(s1, s2):
    result = dot(s1, s2) / dot(linalg.norm(s1),linalg.norm(s2))

    # Fix for problems with float64 and invalid math error
    if allclose(result, 1):
        ac = 0
    else:
        ac = arccos(result)
    return 1 - ac