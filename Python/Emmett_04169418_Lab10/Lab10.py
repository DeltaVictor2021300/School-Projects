
from gtts import gTTS

d = {'a':'alfa', 'b':'bravo', 'c':'charlie', 'd':'delta', 'e':'echo', 'f':'foxtrot',
'g':'golf', 'h':'hotel', 'i':'india', 'j':'juliett', 'k':'kilo', 'l':'lima',
'm':'mike', 'n':'november', 'o':'oscar', 'p':'papa', 'q':'quebec', 'r':'romeo',
's':'sierra', 't':'tango', 'u':'uniform', 'v':'victor', 'w':'whiskey',
'x':'x-ray', 'y':'yankee', 'z':'zulu'}

def stringToICAO(toConv, ref):
    convStr = ''
    toConv.lower()
    for i in range(0, len(toConv)):
        convStr += ref[toConv[i]] + ' '
    return convStr

f = open("stuff.txt", 'r')
fText = f.read()
f.close()

stringToICAO(fText, d)
createMP3 = gTTS(text=stringToICAO(fText, d), lang='en', slow=False)
createMP3.save("stuff.mp3")
