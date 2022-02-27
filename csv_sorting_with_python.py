from ast import Not
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
    for j in range(len(mentee)):
        if allotment_index[j] == -1 and mentor[10][i] == mentee[11][j] and mentor[6][i] == mentee[6][j]:
            allotment_index[j] = i
            mentor[9][i] = mentor[9][i] - 1
            found = True
            break

    if found == False:
        for j in range(len(mentee)):
            if allotment_index[j] == -1 and mentor[10][i] == mentee[11][j]:
                allotment_index[j] = i
                mentor[9][i] = mentor[9][i] - 1
                found = True
                break
    
    if found == False:
        for j in range(len(mentee)):
            if allotment_index[j] == -1 and mentor[10][i] == mentee[12][j]:
                allotment_index[j] = i
                mentor[9][i] = mentor[9][i] - 1
                found = True
                break

    if found == False:
        for j in range(len(mentee)):
            if allotment_index[j] == -1 and mentor[10][i] == mentee[13][j]:
                allotment_index[j] = i
                mentor[9][i] = mentor[9][i] - 1
                found = True
                break

# alloting if have same 1st preference
for i in range(len(mentor)):
    pass



            