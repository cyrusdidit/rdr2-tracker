import json, pathlib
f=pathlib.Path('storage/app/tasks.json')
with f.open('r', encoding='utf-8') as fh:
    tasks=json.load(fh)
print('before',sum(1 for t in tasks if t.get('category')=='Dream Catchers' and 'location' in t))
for t in tasks:
    if t.get('id')==21:
        print('id21 before', t)
updates={
    21:'Northwest of O’Creagh’s Run, on a cliffside pine',
    22:'Near the northern shore of Lake Isabella, on a tree',
    23:'In the Grizzlies West, on a tree near a log',
    24:'East of Big Valley, hanging in a tree on a hill',
    25:'North of Caliga Hall, on a pine by a small stream',
    26:'South of Bacchus Station, near a rock ledge',
    27:'Along the Dakota River, on a tree by the riverbank',
    28:'Near Fort Wallace, on a cliff edge tree',
    29:'Roanoke Ridge, in the forest near the river',
    30:'South of Annesburg, hanging from a tree above the tracks',
    31:'Cumberland Forest, on a tree by a ridge',
    32:'Tall Trees, in a forest clearing',
    33:'West of Valentine, on a tree by a rock formation',
    34:'Near Flatneck Station, hanging from a pine',
    35:'South of Emerald Ranch, on a tree in the plains',
    36:'Bayou Nwa, on a cypress tree in the swamp',
    37:'Northeast of Lagras, on a tree near a river bend',
    38:'West of Cotorra Springs, hanging on a cliffside tree',
    39:'Grizzlies East, on a pine near a snow slope',
    40:'Roanoke Ridge, on a tree above a waterfall'
}
count=0
for t in tasks:
    if t.get('id') in updates and t.get('category')=='Dream Catchers':
        t['location']=updates[t['id']]
        count += 1
with f.open('w', encoding='utf-8') as fh:
    json.dump(tasks, fh, indent=2, ensure_ascii=False)
print('written', count)
with f.open('r',encoding='utf-8') as fh:
    tasks2=json.load(fh)
print('after', sum(1 for t in tasks2 if t.get('category')=='Dream Catchers' and 'location' in t))
for t in tasks2:
    if t.get('id')==21:
        print('id21 after', t)
        break
