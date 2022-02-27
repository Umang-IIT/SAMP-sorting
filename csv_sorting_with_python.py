import pandas as pd
mentee = pd.read_csv('mentee.csv',header=None)

mentor = pd.read_csv('mentor.csv',header=None)

#sorting mentor sheet based on 1st preference
sorted_mentor = mentor.sort_values(10)

#sorting mentee sheet based on 1st preference
sorted_mentee = mentee.sort_values(11)

allotment_index = []
for i in range(len(mentee)):
    allotment_index.append(-1)

#alloting each mentor atleast one mentee
for i in range(len(mentor)):
    found = False
    # alloting if have same preference and Department
    for j in range(len(mentee)):
        if allotment_index[j] == -1 and mentor[10][i] == mentee[11][j] and mentor[6][i] == mentee[6][j]:
            allotment_index[j] = i
            mentor[9][i] = mentor[9][i] - 1
            found = True
            break

    # alloting if have same 1st preference
    if found == False:
        for j in range(len(mentee)):
            if allotment_index[j] == -1 and mentor[10][i] == mentee[11][j]:
                allotment_index[j] = i
                mentor[9][i] = mentor[9][i] - 1
                found = True
                break
    
    # alloting if have same 2nd preference
    if found == False:
        for j in range(len(mentee)):
            if allotment_index[j] == -1 and mentor[10][i] == mentee[12][j]:
                allotment_index[j] = i
                mentor[9][i] = mentor[9][i] - 1
                found = True
                break

    # alloting if have same 3rd preference
    if found == False:
        for j in range(len(mentee)):
            if allotment_index[j] == -1 and mentor[10][i] == mentee[13][j]:
                allotment_index[j] = i
                mentor[9][i] = mentor[9][i] - 1
                found = True
                break

# alloting if have same 1st preference
for i in range(len(mentee)):
    if(allotment_index[i] == -1):
        for j in range(len(mentor)):
            if(mentor[9][j] > 0 and mentor[10][j] == mentee[11][i]):
                allotment_index[i] = j
                mentor[9][j] = mentor[9][j] - 1
                break

# alloting if have same 2nd preference
for i in range(len(mentee)):
    if(allotment_index[i] == -1):
        for j in range(len(mentor)):
            if(mentor[9][j] > 0 and mentor[10][j] == mentee[12][i]):
                allotment_index[i] = j
                mentor[9][j] = mentor[9][j] - 1
                break

# alloting if have same 3rd preference
for i in range(len(mentee)):
    if(allotment_index[i] == -1):
        for j in range(len(mentor)):
            if(mentor[9][j] > 0 and mentor[10][j] == mentee[13][i]):
                allotment_index[i] = j
                mentor[9][j] = mentor[9][j] - 1
                break

# writing to csv file
data = []

for i in range(allotment_index.__len__()):
    if allotment_index[i]!=-1:
        temp = []
        temp.append(mentee[3][i])
        temp.append(mentee[4][i])
        temp.append(mentor[3][allotment_index[i]])
        temp.append(mentor[4][allotment_index[i]])
        temp.append(mentor[14][allotment_index[i]])
        temp.append(mentor[8][allotment_index[i]])
        data.append(temp)

csv = pd.DataFrame(data,columns=['Name','Email','Mentor Name','Mentor Email','Mentor Company','Area of Expertise'])
csv.to_csv('allotment.csv',index=False)