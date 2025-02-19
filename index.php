<?php
require_once 'app/Controllers/taskController.php';
$tasks = new TaskController();
$task = $tasks->getTasks() ?? [];

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Caderno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Petit+Formal+Script&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="public/assets/style.css">
</head>

<body>

    <div class="container">


        <div class="notebook">
            <span class="float-right font-weight-bold currentDate" style="float:right" id="currentDate"></span>

            <div id="taskList">
                <?php
                foreach ($task as $tasks):
                    ?> <span class="task">
                        <?php if($tasks['completed' ] == 0):?>    
                        <form action="app/routes/taskRoutes.php?action=complete" method="post">
                        <button type="submit"
                                class="btn btn-link" name="taskId" value="<?= $tasks['id'] ?>"><i
                                    class="fa-regular fa-circle-check"></i></button></form>
                                       
                                    
                                    
                                        <?= $tasks['description']  ?>
                                   
                       
                            <button class="btn btn-link"><i class="fa-regular fa-pen-to-square"></i></button>
                            <button type="button" class="btn btn-link" name="taskId" value="<?= $tasks['id'] ?>" onclick="deleteTask(<?= $tasks['id'] ?>)"><i class="fa-regular fa-trash-can"></i></button>
                       
                        <form id="deleteTaskForm" action="app/routes/taskRoutes.php?action=delete" method="post" style="display: none;">
    <input type="hidden" name="taskId" id="deleteTaskId">
</form>
                        <?php elseif($tasks['completed'] == 1):?>
                                        <p class="completed"><?= $tasks['description']  ?></p>
                                       <?php endif ?>
                    </span>
                   
                <?php endforeach; ?>
            </div>


            <form action="app/routes/taskRoutes.php?action=add" method="post" class="task-form">
                <div class="control-buttons">
                    <input type="text" id="taskInput" class="form-control mb-2" placeholder="Digite sua tarefa..."
                        oninput="toggleAddCancelButtons(this)" name="description" autofocus>
                    <button type="submit" class="btn btn-success" id="addButton"><i
                            class="fa-solid fa-plus"></i></button>
                    <button type="reset" class="btn btn-danger" id="cancelButton" onclick="clearInput()"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
            </form>
        </div>

        <div class="text-center mt-3">
            <button class="btn btn-light">⬅</button>
            <button class="btn btn-light">➡</button>
        </div>
        <div class="header">
            <button class="btn btn-danger stress-button-danger" onclick="openPopup()">😤 Botão do Estresse</button>

            <div for="humor">
                <h5>Como está seu humor?</h5>
                <select class="form-control d-inline" style="width: auto;">

                    <option>😀 Feliz</option>
                    <option>😐 Neutro</option>
                    <option>😟 Triste</option>
                    <option>😡 Irritado</option>
                    <option>😴 Cansado</option>

                </select>
            </div>
        </div>
        <div id="stressPopup" class="popup">
            <div class="popup-content">
                <span class="close" onclick="closePopup()">&times;</span>
                <h3>Motivos do Estresse</h3>
                <button class="btn btn-secondary stress-button" style="background-color: #ff9999;"
                    onclick="showTip('Trabalho')">💼 Trabalho</button>
                <button class="btn btn-secondary stress-button" style="background-color: #ffcc99;"
                    onclick="showTip('Família')">🏠 Família</button>
                <button class="btn btn-secondary stress-button" style="background-color: #ffff99;"
                    onclick="showTip('Saúde')">💊 Saúde</button>
                <button class="btn btn-secondary stress-button" style="background-color: #99ff99;"
                    onclick="showTip('Finanças')">💰 Finanças</button>
                <button class="btn btn-secondary stress-button" style="background-color: #99ccff;"
                    onclick="showTip('Daniel')">💍 Daniel</button>

                <div id="tipMessage" class="tip-message"></div>
                <div id="imageSlider" class="image-slider"></div>
            </div>
        </div>
    </div>

    <script>
            function deleteTask(taskId) {
        if (confirm('Tem certeza de que deseja deletar esta tarefa?')) {
            document.getElementById('deleteTaskId').value = taskId;
            document.getElementById('deleteTaskForm').submit();
        }
    }
        document.getElementById('currentDate').innerText = new Date().toLocaleDateString();

        const taskList = document.getElementById('taskList');
        const taskInput = document.getElementById('taskInput');
        const addButton = document.getElementById('addButton');
        const cancelButton = document.getElementById('cancelButton');

        toggleAddCancelButtons = (input) => {
            const isNotEmpty = input.value.trim().length > 0;
            addButton.style.display = isNotEmpty ? 'inline-block' : 'none';
            cancelButton.style.display = isNotEmpty ? 'inline-block' : 'none';
        }

        clearInput = () => {
            taskInput.value = '';
            toggleAddCancelButtons(taskInput);
        }


        function openPopup() {
            document.getElementById('stressPopup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('stressPopup').style.display = 'none';
        }

        function showTip(reason) {
            const tips = {
                'Trabalho': [
                    'Respire fundo e faça uma pausa. Lembre-se de que você está fazendo o seu melhor.',
                    'Organize suas tarefas e priorize o que é mais importante.',
                    'Lembre-se de que é importante equilibrar trabalho e descanso.'
                ],
                'Família': [
                    'Converse com alguém de confiança sobre seus sentimentos. A comunicação é essencial.',
                    'Reserve um tempo para atividades em família que todos gostem.',
                    'Lembre-se de que todos têm dias difíceis. Seja paciente.'
                ],
                'Saúde': [
                    'Cuide de si mesmo. Faça uma caminhada ou pratique um hobby que você goste.',
                    'Mantenha uma alimentação saudável e beba bastante água.',
                    'Durma bem e descanse o suficiente para recarregar suas energias.'
                ],
                'Finanças': [
                    'Organize suas finanças e faça um plano. Lembre-se de que tudo se resolve com o tempo.',
                    'Evite gastos desnecessários e foque no que é essencial.',
                    'Procure ajuda profissional se necessário para gerenciar suas finanças.'
                ],
                'Daniel': [
                    'Caso tenha tido uma discussão com o Daniel, certamente você está errada, peça desculpas kkkkk. Quero que lembre um pouco das coisas boas que passaram todo esse tempo juntos e o quanto você é amada pelo Daniel:',
                    'Talvez seja impossível eu resumir tudo o que vocês passaram juntos, mas lembre-se de que o amor de vocês é maior do que qualquer problema. Quero que lembre um pouco de como é a realidade de vocês dois juntos:',
                    'Sabemos o quanto pensamos diferente um do outro e o quanto isso nunca impediu de estarmos juntos. Quero que lembre um pouco do quanto nos amamos e o motivo de sempre sabermos escutar e entender um ao outro: '
                ]
            };

            const images = {
                'Trabalho': ['trabalho1.jpg', 'trabalho2.jpg'],
                'Família': ['familia1.jpg', 'familia2.jpg'],
                'Saúde': ['saude1.jpg', 'saude2.jpg'],
                'Finanças': ['financas1.jpg', 'financas2.jpg'],
                'Daniel': ['daniel1.jpg', 'daniel2.jpg']
            };

            const randomTip = tips[reason][Math.floor(Math.random() * tips[reason].length)];
            document.getElementById('tipMessage').innerText = randomTip;

            const imageSlider = document.getElementById('imageSlider');
            imageSlider.innerHTML = '';
            images[reason].forEach(image => {
                const imgElement = document.createElement('img');
                imgElement.src = `public/assets/images/${image}`;
                imgElement.classList.add('slider-image');
                imageSlider.appendChild(imgElement);
            });

            let currentIndex = 0;
            const sliderImages = imageSlider.querySelectorAll('.slider-image');
            if (sliderImages.length > 0) {
                sliderImages[currentIndex].classList.add('active');
                setInterval(() => {
                    sliderImages[currentIndex].classList.remove('active');
                    currentIndex = (currentIndex + 1) % sliderImages.length;
                    sliderImages[currentIndex].classList.add('active');
                }, 5000);
            }

            const buttons = document.querySelectorAll('.stress-button');
            buttons.forEach(button => {
                button.classList.remove('selected');
                button.disabled = false;
            });

            const selectedButton = Array.from(buttons).find(button => button.textContent.includes(reason));
            selectedButton.classList.add('selected');
            selectedButton.disabled = true;
        }

        document.querySelector('.stress-button-danger').addEventListener('click', openPopup);
    </script>
    <script src="https://kit.fontawesome.com/1f3d33bbf2.js" crossorigin="anonymous"></script>
</body>

</html>