<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INWN AI CHAT</title>

    <style>
        body,html {
            font-family: Apple Color Emoji;
            margin: 0;
            background: #1e1e1e;
            color: white;
        }

        .chat-container {
            padding: 20px;
            background: #1e1e1e;
            padding-bottom: 200px;
        }

        .message {
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            color: white;
        }

        .message.user {
            flex-direction: row-reverse;
        }

        .message .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
            margin: 0 10px;
        }

        .message.user .avatar {
            background-color: #28a745;
        }

        .message .text {
            max-width: 70%;
            background-color: rgba(0,0,0,.05);
            padding: 10px;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 14px;
            line-height: 1.5;
            border: 1px solid hsla(0,0%,100%,.192);
            transition: all .3s ease;
        }

        .message.user .text {
            background-color: #1b262a;
        }

        .chat-form {
            display: flex;
            flex-direction: column;
            position: fixed;
            bottom: 10px;
            right: 10px;
            left: 10px;
            background: #1e1e1e;
        }
        .form {
            display: flex;
            flex-direction: column;
        }
        code{
            display: block;
            overflow-x: auto;
            color: #abb2bf;
            background: #282c34;
            padding: 1em;
            border-radius: 10px;
        }
        p{
            margin: 0;
        }
        .chat-form textarea {
            resize: none;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .chat-form button {
            padding: 10px 15px;
            font-size: 16px;
            background: linear-gradient(100.84deg,#1ebdc3 -15.85%,#153fa7 78.33%);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }

        .chat-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="chat-container">
    <h1>INWN AI CHAT</h1>

    @if (isset($history) && count($history) > 0)
        @foreach ($history as $message)
            <div class="message {{ $message['role'] }}">
                <div class="avatar">
                    {{ $message['role'] === 'user' ? 'U' : 'A' }}
                </div>
                <div class="text">
                    @markdown
                    {!! $message['content'] !!}
                    @endmarkdown
                </div>
            </div>
        @endforeach
    @else
        <p>Чат пока пуст. Начните разговор!</p>
    @endif

</div>
<div class="chat-form">
    <form action="openai" method="POST" class="form" >
        @csrf
        <textarea name="question" id="question" rows="3" placeholder="Введите ваш запрос..." required>{{ old('question') }}</textarea>
        <button type="submit">Отправить</button>
    </form>
    <div id="responseMessage" style="display: none;"></div>
    <form action="{{ route('chat.clear') }}" method="POST" style="margin-top: 10px;">
        @csrf
        <button type="submit" style="width: 100%">
            Очистить историю
        </button>
    </form>
</div>

</body>
</html>
