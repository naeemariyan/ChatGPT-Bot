document.getElementById('sendButton').addEventListener('click', async () => {
    const userInput = document.getElementById('userInput').value;
    if (!userInput) return;

    const responseDiv = document.getElementById('response');
    responseDiv.innerHTML = 'Loading...';

    const response = await fetch('includes/process.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ message: userInput }),
    });

    const result = await response.json();
    responseDiv.innerHTML = result.reply;
});
