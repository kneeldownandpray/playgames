<template>


  <data style="display: none;">
    <form method="post" action="add.php">
      <input type="text" name="player1score" v-model="pointsOfOne">
      <input type="text" name="player2score" v-model="pointsOfTwo">
      <input type="text" name="player1name" v-model="sendtoDbnameP1">
      <input type="text" name="player2name" v-model="sendtoDbnameP2">
      <input type="submit" value="Save" ref="submitButton">
    </form>
  </data>
  <!-- <div style="background-color: red; position: fixed; height: 100%; width: 50%; padding: 20px; z-index: 11;">
    <input type="text" name="" placeholder="Insert Player 1 name" v-model="nameOfPlayer1">
    <input type="text" name="" placeholder="Insert Player 2 name" v-model="nameOfPlayer2">
    <input type="submit" value="Save" @click="savename">
  </div> -->
  <audio ref="audioPlayer" src="/src/assets/bgAudio.m4a" loop></audio>
  <audio ref="audioPlayerWin" src="/src/assets/win.m4a"></audio>
  <q-dialog v-model="dialogOpen" persistent>
    <q-card>
      <q-card-section>
        <div class="text-h6">Enter Player Names</div>
      </q-card-section>


      <q-card-section>
        <q-input filled v-model="nameOfPlayer1" label="Player 1 Name" :rules="[val => !!val || 'Field is required']"
          style="margin-bottom: 3px;" />
        <q-input filled v-model="nameOfPlayer2" label="Player 2 Name" :rules="[val => !!val || 'Field is required']" />
      </q-card-section>

      <q-card-section>
        <q-input filled v-model="limitOfQuestion" label="How Many Question"
          :rules="[val => !!val || 'Field is required']" />
        <q-input filled v-model="SecondsPerQuestion" label="Time Per Question"
          :rules="[val => !!val || 'Field is required']" />
      </q-card-section>

      <q-card-section>
        <q-select filled v-model="background" :rules="[val => !!val || 'Field is required']" :options="maps"
          label="Select Map" />
      </q-card-section>
      <q-card-section>
        <q-select filled v-model="player1" :rules="[val => !!val || 'Field is required']" :options="characters"
          label="Select Player 1 Character" style="margin-bottom: 5px;" />
        <q-select filled v-model="player2" :rules="[val => !!val || 'Field is required']" :options="characters"
          label="Select Player 2 Character" style="margin-bottom: 20px;" />
        <div style="display: flex; width: 80%; display: flex;
      justify-content: space-evenly;">
          <div>
            player 1
            <div :class="this.player1"></div>
          </div>
          <div>
            player 2
            <div :class="this.player2"></div>
          </div>
        </div>
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat label="Cancel" v-close-popup />

        <q-btn color="primary" label="Save" @click="validateAndSave" v-close-popup />
      </q-card-actions>
    </q-card>
  </q-dialog>
  <!-- v-if="hasAnameofPlayer" -->
  <div class="game-area" v-if="this.gumagana">
    <div class="middle-wrap-text">
      <div class="countdown-text"> <span style="padding: 10px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 8px;"> CountdownTime {{ countdowntime }}</span></div>
    </div>
    <canvas id="gameCanvas" width="800" height="600"
      :style="{ 'background-image': `url('/src/assets/${this.background}.png')` }"></canvas>
    <div v-if="currentQuestion" class="question">
      <h4>Question {{ currentQuestionIndex + 1 }}</h4><br>
      <p>{{ currentQuestion.TypeOfquestion }}</p>
      <p class="questionair-front">{{ currentQuestion.question }}</p>
      <p style="color: green;"> Choice A: {{ currentQuestion.choiceA }}</p>
      <p style="color: green;">Choice B: {{ currentQuestion.choiceB }}</p>
      <p style="color: green;">Choice C: {{ currentQuestion.choiceC }}</p>
      <p style="color: green;">Choice D: {{ currentQuestion.choiceD }}</p>
    </div>
    <div>
      <br><br><br><br>
      <!-- <div class="middle-wrap-text">
        <div class="playerOnetext"> player 1 is {{ this.answerOfOne }}</div>
        <div class="playerTwotext"> player 2 is {{ this.answerOfTwo }}</div>
      </div><br><br><br><br> -->

      <div class="middle-wrap-text">
        <div class="correctAnswer" v-if="this.toggle3"><span class="correctbg"> {{ this.DisplayCorrectAnswer }}</span>
        </div>
        <div class="correctAnswer" v-else><span class="correctbg"> {{ this.DisplayCorrectAnswer }}</span></div>
        <div class="playerOnetext" v-if="this.toggle2"> {{ this.sendtoDbnameP1 }} points : {{ this.pointsOfOne }}</div>
        <div class="playerOnetext" v-else> {{ this.sendtoDbnameP1 }} points : {{ this.pointsOfOne }}</div>
        <div class="playerTwotext" v-if="this.toggle1"> {{ this.sendtoDbnameP2 }} points : {{ this.pointsOfTwo }}</div>
        <div class="playerTwotext" v-else> {{ this.sendtoDbnameP2 }} points : {{ this.pointsOfTwo }}</div>
      </div>

    </div>
  </div>
  <div>
  </div>

</template>
<script>
import axios from 'axios';
export default {
  mounted() {

  },
  data() {
    return {
      countdowntime: 0,
      countOfQuestion: 0,
      questionChangeInterval: 0, //timeperQuestion
      background: '',
      dialogOpen: true,
      answerOfOne: null,
      answerOfTwo: null,
      nameOfPlayer1: '',
      nameOfPlayer2: '',
      sendtoDbnameP2: '',
      sendtoDbnameP1: '',
      questions: [],
      currentQuestionIndex: 0,
      answerHere: null,
      pointsOfOne: 0,
      pointsOfTwo: 0,
      gumagana: true,
      timeofInterval: 300,
      limitOfQuestion: 0, //how many question
      player1: null,
      player2: null,
      SecondsPerQuestion: 0,
      toggle1: false,
      toggle2: false,
      toggle3: false,
      maps: [
        'day',
        'night',
      ],
      characters: [
        'character1',
        'character2',
        'character3',
        'character4',

      ],
    }
  },
  computed: {
    currentQuestion() {
      return this.questions[this.currentQuestionIndex]; // Computed property to get the current question
    },
  },
  watch: {
    'currentQuestion.correctAnswer': function (newValue) {
      this.answerHere = newValue;
    }
  },
  methods: {


    validateAndSave() {

      if (this.nameOfPlayer1 && this.nameOfPlayer2 && this.player1 && this.player2 && this.background) {
        this.savename();
      }
      else {
        alert("please fill up the field propperly")
        this.$router.go(0);
      }
    },
    playAudio() {
      const audioPlayer = this.$refs.audioPlayer;
      audioPlayer.currentTime = 2; // Skip the first 2 seconds
      audioPlayer.loop = true; // Enable looping
      audioPlayer.play();
    },
    playAudioWin() {
      this.$refs.audioPlayerWin.play();
    },
    savename() {
      this.sendtoDbnameP2 = this.nameOfPlayer2;
      this.sendtoDbnameP1 = this.nameOfPlayer1;
      this.convertSecondsToInterval();
      this.initGame();
      this.fetchQuestions();
      this.changeQuestionEveryFiveSeconds();
      this.playAudio();
    },
    checkAndUpdatePoints() {
      this.toggle3 = !this.toggle3;
      this.DisplayCorrectAnswer = this.answerHere;
      if (this.answerOfOne === this.answerHere) {
        this.pointsOfOne += 1;
        this.toggle2 = !this.toggle2;
        this.playAudioWin();
      }
      if (this.answerOfTwo === this.answerHere) {
        this.pointsOfTwo += 1;
        this.toggle1 = !this.toggle1;
        this.playAudioWin();
      }
    },

    convertSecondsToInterval() {
      this.questionChangeInterval = this.SecondsPerQuestion * 1000;
      console.log(this.questionChangeInterval);
    },

    changeQuestionEveryFiveSeconds() {
      // Set the countdown time based on the current question's time interval
      this.countOfQuestion = this.countOfQuestion + 1;
      this.countdowntime = this.questionChangeInterval / 1000;

      // Function to decrement the countdown and check if it's time to change the question
      const decrementCountdownAndCheck = () => {
        this.countdowntime--;
        if (this.countdowntime > 0) {
          // If countdown is not over, schedule the next decrement
          setTimeout(decrementCountdownAndCheck, 1000);
        } else {
          // When countdown reaches 0, change the question
          this.currentQuestionIndex = (this.currentQuestionIndex + 1) % this.questions.length;
          this.checkAndUpdatePoints();
          // Schedule the next question change
          console.log("ganto kadami", this.countOfQuestion)
          if (this.countOfQuestion == this.limitOfQuestion) {
            this.autoClickSubmit();
          }
          this.changeQuestionEveryFiveSeconds();
        }
      };

      // Start the countdown
      decrementCountdownAndCheck();
    },
    fetchQuestions() {
      axios.get('http://localhost:9000/get_questions.php')
        .then(response => {
          this.questions = response.data;
          console.log(this.questions);
        })
        .catch(error => {
          console.error('Error fetching questions:', error);
        });
    },
    autoClickSubmit() {
      setTimeout(() => {
        this.$refs.submitButton.click();
      }, this.timeofInterval); // 5000 milliseconds = 5 seconds
    },
    initGame() {
      const canvas = document.getElementById('gameCanvas');
      const ctx = canvas.getContext('2d');

      // Create two div elements for players
      const player1Div = document.createElement('div');
      player1Div.classList.add(this.player1);
      canvas.parentElement.appendChild(player1Div); // Append player1 div to canvas parent

      const player2Div = document.createElement('div');
      player2Div.classList.add(this.player2);
      canvas.parentElement.appendChild(player2Div);

      const obstacleDivs = [];
      for (let i = 0; i < 3; i++) {
        const obstacleDiv = document.createElement('div');
        obstacleDiv.classList.add('obstacle');
        canvas.parentElement.appendChild(obstacleDiv);
        obstacleDivs.push(obstacleDiv);
      }

      const obstacleWidth = 10; // Width of each obstacle
      const canvasWidth = canvas.width;
      const marginLeft = -20; // Margin-like effect on the left

      obstacleDivs.forEach((obstacleDiv, index) => {
        // Calculate the position for each obstacle, considering the margin-left
        const obstaclePosition = (canvasWidth / 4) * (index + 1) - obstacleWidth / 2 + marginLeft;
        obstacleDiv.style.left = `${obstaclePosition}px`;
        obstacleDiv.style.top = `${canvas.height - obstacleDiv.offsetHeight}px`; // Position at the bottom of the canvas
      });
      // Example: Move the obstacles upwards
      function updateObstaclePositions() {
        obstacleDivs.forEach(obstacleDiv => {
          obstacleDiv.style.top = `${parseInt(obstacleDiv.style.top) - 5}px`;
          // Add logic to reset the obstacle's position if it moves off-screen
        });
      }

      // Call this function in your game loop or at a regular interval
      updateObstaclePositions();
      // Game variables


      let player1 = {
        x: 200,
        y: 200,
        width: 100,
        height: 100,
        speed: 3,
        maxSpeed: 5,
        acceleration: 2,
        deceleration: 2,
        velocity: 0,
        jumping: false,
        gravity: 1,
        jumpHeight: 15,
        jumpForce: 20,
      };

      let player2 = {
        x: 200, // Start player2 at a different position
        y: 200,
        width: 100,
        height: 100,
        speed: 3,
        maxSpeed: 5,
        acceleration: 2,
        deceleration: 2,
        velocity: 0,
        jumping: false,
        gravity: 1,
        jumpHeight: 15,
        jumpForce: 20,

      };

      for (let i = 0; i < 3; i++) {
        const obstacleDiv = document.createElement('div');
        obstacleDiv.classList.add('obstacle');
        canvas.parentElement.appendChild(obstacleDiv);
        obstacleDivs.push(obstacleDiv);
      }

      // Function to get obstacle properties
      function getObstacleProperties(obstacleDiv) {
        return {
          x: parseInt(obstacleDiv.style.left),
          y: parseInt(obstacleDiv.style.top),
          width: obstacleDiv.offsetWidth,
          height: obstacleDiv.offsetHeight
        };
      }

      function isColliding(player, obstacle) {
        return player.x < obstacle.x + obstacle.width &&
          player.x + player.width > obstacle.x &&
          player.y < obstacle.y + obstacle.height &&
          player.y + player.height > obstacle.y;
      }

      function checkCollisions() {
        obstacleDivs.forEach(obstacleDiv => {
          const obstacle = getObstacleProperties(obstacleDiv);

          if (isColliding(player1, obstacle)) {
            console.log('Player 1 collided with an obstacle');
            // Adjust player1's position to prevent movement through the obstacle
            if (player1.x < obstacle.x) {
              // Player1 is moving left, adjust right edge
              player1.x = obstacle.x - player1.width;
            } else if (player1.x + player1.width > obstacle.x + obstacle.width) {
              // Player1 is moving right, adjust left edge
              player1.x = obstacle.x + obstacle.width;
            }
            // Add similar logic for vertical movement if needed
          }

          if (isColliding(player2, obstacle)) {
            console.log('Player 2 collided with an obstacle');
            // Adjust player2's position to prevent movement through the obstacle
            if (player2.x < obstacle.x) {
              // Player2 is moving left, adjust right edge
              player2.x = obstacle.x - player2.width;
            } else if (player2.x + player2.width > obstacle.x + obstacle.width) {
              // Player2 is moving right, adjust left edge
              player2.x = obstacle.x + obstacle.width;
            }
            // Add similar logic for vertical movement if needed
          }
        });
      }
      // Game loop
      function gameLoop() {
        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        player1.y = Math.min(player1.y, canvas.height - player1.height - 30); // 50px "bottom margin"
        player2.y = Math.min(player2.y, canvas.height - player2.height - 30); // 50px "bottom margin"

        // Update positions of player div elements
        player1Div.style.left = player1.x + 'px';
        player1Div.style.top = player1.y + 'px';

        player2Div.style.left = player2.x + 'px';
        player2Div.style.top = player2.y + 'px';

        // Update player movements and jumping
        if (player1.jumping) {
          player1.y -= player1.jumpForce;
          player1.jumpForce -= player1.gravity;
          if (player1.jumpForce < -player1.jumpHeight) {
            player1.jumpForce = -player1.jumpHeight;
            player1.jumping = false;
          }
        } else {
          player1.y += player1.speed;
        }

        // Apply velocity to Player1
        player1.x += player1.velocity;

        // Boundary check for Player1
        if (player1.y + player1.height > canvas.height) {
          player1.y = canvas.height - player1.height;
          player1.jumping = false;
        }
        if (player1.x < 0) {
          player1.x = 0;
        } else if (player1.x + player1.width > canvas.width) {
          player1.x = canvas.width - player1.width;
        }

        // Update player2 movements and jumping
        if (player2.jumping) {
          player2.y -= player2.jumpForce;
          player2.jumpForce -= player2.gravity;
          if (player2.jumpForce < -player2.jumpHeight) {
            player2.jumpForce = -player2.jumpHeight;
            player2.jumping = false;
          }
        } else {
          player2.y += player2.speed;
        }

        // Apply velocity to Player2
        player2.x += player2.velocity;

        // Boundary check for Player2
        if (player2.y + player2.height > canvas.height) {
          player2.y = canvas.height - player2.height;
          player2.jumping = false;
        }
        if (player2.x < 0) {
          player2.x = 0;
        } else if (player2.x + player2.width > canvas.width) {
          player2.x = canvas.width - player2.width;
        }
        checkCollisions();
        requestAnimationFrame(gameLoop);
      }

      gameLoop();
      setInterval(() => {
        const quarterWidth = canvas.width / 4;
        if (player1.x < quarterWidth) {
          this.answerOfOne = "A";
        } else if (player1.x < quarterWidth * 2) {
          this.answerOfOne = "B";
        } else if (player1.x < quarterWidth * 3) {
          this.answerOfOne = "C";
        } else {
          this.answerOfOne = "D";
        }
      }, 1000);
      setInterval(() => {
        const quarterWidth = canvas.width / 4;
        if (player2.x < quarterWidth) {
          this.answerOfTwo = "A";
        } else if (player2.x < quarterWidth * 2) {
          this.answerOfTwo = "B";
        } else if (player2.x < quarterWidth * 3) {
          this.answerOfTwo = "C";
        } else {
          this.answerOfTwo = "D";
        }
      }, 1000);
      // Event listeners for player movement
      window.addEventListener('keydown', (e) => {
        // Player1 jump
        if (e.key === 'w' || e.key === 'W') {
          player1.jumping = true;
          player1.jumpForce = player1.jumpHeight; // Assuming jumpForce is used to control the jump height
        } else if (e.key === 'a' || e.key === 'A') {
          player1.velocity = Math.min(player1.velocity - player1.acceleration, -player1.maxSpeed);
          player1Div.style.transform = `scaleX(-1)`;
        } else if (e.key === 's' || e.key === 'S') {
          player1.velocity = Math.min(player1.velocity + player1.acceleration, player1.maxSpeed);
        } else if (e.key === 'd' || e.key === 'D') {
          player1.velocity = Math.max(player1.velocity + player1.acceleration, player1.maxSpeed);
          player1Div.style.transform = `scaleX(1)`;
        }
        // Player2 jump
        if (e.key === 'ArrowUp') {
          player2.jumping = true;
          player2.jumpForce = player2.jumpHeight; // Assuming jumpForce is used to control the jump height
        } else if (e.key === 'ArrowLeft') {
          player2.velocity = Math.min(player2.velocity - player2.acceleration, -player2.maxSpeed);
          player2Div.style.transform = `scaleX(-1)`;
        } else if (e.key === 'ArrowDown') {
          player2.velocity = Math.min(player2.velocity + player2.acceleration, player2.maxSpeed);
        } else if (e.key === 'ArrowRight') {
          player2.velocity = Math.max(player2.velocity + player2.acceleration, player2.maxSpeed);
          player2Div.style.transform = `scaleX(1)`;
        }
      });

      window.addEventListener('keyup', (e) => {
        if ((e.key === 'w' || e.key === 'a' || e.key === 's' || e.key === 'd' || e.key === 'W' || e.key === 'A' || e.key === 'S' || e.key === 'D') ||
          (e.key === 'ArrowUp' || e.key === 'ArrowLeft' || e.key === 'ArrowDown' || e.key === 'ArrowRight')) {
          player1.velocity = 0;
          player2.velocity = 0;
        }
      });
    },
  },
};
</script>
<style>
/* Resetting default browser styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Body styles */
body {
  font-family: 'Arial', sans-serif;
  background-color: #f0f0f0;
}

/* Game area container */
.game-area {
  position: relative;
  width: 800px;
  height: 600px;
  margin: 20px auto;
  background-color: #fff;
  border: 2px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

/* Canvas styles */
#gameCanvas {
  display: block;
  width: 100%;
  height: 100%;
  border-radius: 8px;
  background-image: url('/src/assets/background.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;

  /* Add other styles as needed */
}

/* Question container */
.question {
  position: absolute;
  top: 20px;
  left: 20px;
  padding: 20px;
  background-color: rgba(255, 255, 255, 0.8);
  border-radius: 8px;
  font-family: 'Press Start 2P', cursive;
  /* Custom font style for questions */
}

/* Countdown time */
.playerTwotext {
  top: 20px;
  right: 20px;
  font-size: 18px;
  color: #333;
  font-family: 'Press Start 2P', cursive;
  /* Custom font style for countdown time */
}

.obstacle {
  position: absolute;
  width: 50px;
  /* Adjust the width as needed */
  height: 100px;
  /* Adjust the height as needed */

}

/* Player info container */
.middle-wrap-text {
  position: absolute;
  bottom: -3px;
  /* width: calc(50% - 40px); */
  padding: 10px;
  border-radius: 8px;
  display: flex;
  width: 100%;
  justify-content: space-between;
}

/* Player text styles */
.playerOnetext,
.playerTwotext {
  padding: 10px;
  background-color: rgba(255, 255, 255, 0.8);
  border-radius: 8px;
  font-size: 16px;
  color: rgba(49, 42, 0, 0.8);
  font-family: 'Press Start 2P', cursive;
  animation: scaleAnimation 0.5s;
  /* Custom font style for player info */
}

@keyframes scaleAnimation {
  0% {
    transform: scale(0);
    background-color: rgb(255, 208, 0);
  }

  50% {
    transform: scale(1.1);

  }

  100% {
    transform: scale(1);
    background-color: white;
  }
}

.countdown-text {

  margin: -561px -620px 0 486px;
  font-size: 32px;
  font-family: 'Press Start 2P', cursive;
}

.q-card {
  width: 60%;
}


.dinasour {
  position: absolute;
  width: 100px;
  height: 100px;
  background-size: 100% 100%;
  /* Adjusted to fill the div */
  background-image: url('/src/assets/dinasour.gif');
  background-repeat: no-repeat;
  /* Prevents the image from repeating */
  background-position: center;
  /* Centers the image in the div */
}

.character1 {
  position: absolute;
  width: 100px;
  height: 100px;
  background-size: 100% 100%;
  /* Adjusted to fill the div */
  background-image: url('/src/assets/character1.gif');
  background-repeat: no-repeat;
  /* Prevents the image from repeating */
  background-position: center;
  /* Centers the image in the div */
}

.correctAnswer {

  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 20px;
  position: absolute;
  margin: -200px 0px 0px 0px;
  font-size: 60px;
  font-family: 'Press Start 2P', cursive;
  animation: moveFromBottomToTop 0.5s linear forwards;
  ;
}

.correctbg {
  background-color: rgba(255, 253, 253, 0.692);
  padding: 10px;
  border-radius: 20px;
}

/* Custom font style for player info */

@keyframes moveFromBottomToTop {
  0% {
    transform: translateY(100%);
    /* Start from the bottom of the container */
  }

  100% {
    transform: translateY(-100%);
    /* End at the top of the container */
    opacity: 0;
  }
}

.character2 {
  position: absolute;
  width: 100px;
  height: 100px;
  background-size: 100% 100%;
  /* Adjusted to fill the div */
  background-image: url('/src/assets/character2.gif');
  background-repeat: no-repeat;
  /* Prevents the image from repeating */
  background-position: center;
  /* Centers the image in the div */
}

.character3 {
  position: absolute;
  width: 100px;
  height: 100px;
  background-size: 100% 100%;
  /* Adjusted to fill the div */
  background-image: url('/src/assets/character3.gif');
  background-repeat: no-repeat;
  /* Prevents the image from repeating */
  background-position: center;
  /* Centers the image in the div */

}

.character4 {
  position: absolute;
  width: 100px;
  height: 100px;
  background-size: 100% 100%;
  /* Adjusted to fill the div */
  background-image: url('/src/assets/character4.gif');
  background-repeat: no-repeat;
  /* Prevents the image from repeating */
  background-position: center;
  /* Centers the image in the div */
}

.character5 {
  position: absolute;
  width: 100px;
  height: 100px;
  background-size: 100% 100%;
  /* Adjusted to fill the div */
  background-image: url('/src/assets/character5.gif');
  background-repeat: no-repeat;
  /* Prevents the image from repeating */
  background-position: center;
  /* Centers the image in the div */
}

.character6 {
  position: absolute;
  width: 100px;
  height: 100px;
  background-size: 100% 100%;
  /* Adjusted to fill the div */
  background-image: url('/src/assets/character6.gif');
  background-repeat: no-repeat;
  /* Prevents the image from repeating */
  background-position: center;
  /* Centers the image in the div */
}
</style>
