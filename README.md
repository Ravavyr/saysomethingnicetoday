# saysomethingnicetoday

#DATA:
- Get quote list from https://github.com/TheSinding/randomly-nice-api

#Vue:
- build frontend [Say Something Nice To Someone: input form, let them search the api list, submit list object id to endpoint and show thank you message]
- Post to https://api.saysomethingnice.today/post [username,compliment]


#PHP:
- post.php => $_POST['username'] and $_POST['compliment'];
- endpoint to accept [quote id, and twitter id]
- connect to twitter API and post as @SmthNiceToday
- add "Someone wanted to say something nice to you today:" followed by quote and tag twitter id.