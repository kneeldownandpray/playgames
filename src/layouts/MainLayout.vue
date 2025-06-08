<template>
  <q-layout view="lHh Lpr lFf">
    <!-- Header -->
    <q-header>
      <q-toolbar>
        <q-btn @click="toggleLeftDrawer" flat round dense icon="menu" class="q-mr-sm" />
        <q-toolbar-title>Welcome to My Game</q-toolbar-title>
        <!-- Add any other header content here -->
      </q-toolbar>
    </q-header>

    <!-- Left Drawer -->
    <q-drawer v-model="leftDrawerOpen" side="left" overlay behavior="mobile">
      <!-- Drawer content goes here -->
      <!-- For example, you can add navigation links -->
      <q-list>
        <a @click="CheckPassAndGoToAllquestions" rel="noopener noreferrer" style="text-decoration: none; color: black;">
          <q-item clickable>
            <q-item-section>
              <q-item-label>Add Question</q-item-label>
            </q-item-section>
          </q-item>
        </a>
        <!-- Add more links if needed -->
      </q-list>
      <q-list>
        <a @click="CheckPassAndGoToAllquestions1" rel="noopener noreferrer"
          style="text-decoration: none; color: black;">
          <q-item clickable>
            <q-item-section>
              <q-item-label>Show Student Records</q-item-label>
            </q-item-section>
          </q-item>
        </a>
        <!-- Add more links if needed -->
      </q-list>
      <q-list>
        <a @click="CheckPassAndGoToAllquestions" rel="noopener noreferrer" style="text-decoration: none; color: black;">
          <q-item clickable>
            <q-item-section>
              <q-item-label>Manage Quiz Questionaire</q-item-label>
            </q-item-section>
          </q-item>
        </a>
        <!-- Add more links if needed -->
      </q-list>
    </q-drawer>

    <!-- Main content -->
    <q-page-container>
      <router-view />
    </q-page-container>

    <!-- Footer -->
    <q-footer>
      <!-- Footer content goes here -->
      <!-- For example, you can add footer links or copyright information -->
      <div class="row justify-center">
        <span>Copyright © 2024 My App</span>
      </div>
    </q-footer>
  </q-layout>

  <!-- Password Dialog -->
  <q-dialog v-model="passwordDialogOpen" persistent>
    <q-card>
      <q-card-section>
        <div class="text-h6">Enter Password for Admin</div>
      </q-card-section>

      <q-card-section>
        <q-input v-model="passwordInput" type="password" label="Password" />
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat label="Cancel" v-close-popup />
        <q-btn flat label="Submit" @click="submitPassword" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script setup>
import { ref } from 'vue'
import { QDialog, QCard, QCardSection, QCardActions, QInput, QBtn } from 'quasar'

defineOptions({
  name: 'MainLayout',
  components: {
    QDialog, QCard, QCardSection, QCardActions, QInput, QBtn
  }
})

const leftDrawerOpen = ref(false)
const passwordDialogOpen = ref(false)
const passwordInput = ref('')
const correctPassword = 'water123'

function toggleLeftDrawer() {
  if (passwordInput.value === correctPassword) {
    leftDrawerOpen.value = !leftDrawerOpen.value
  } else {
    passwordDialogOpen.value = true
  }
}

function submitPassword() {
  if (passwordInput.value === correctPassword) {
    passwordDialogOpen.value = false
    leftDrawerOpen.value = !leftDrawerOpen.value
  } else {
    // Handle incorrect password
    alert('Incorrect password')
  }
}

function CheckPassAndGoToAllquestions() {
  window.location.href = '/adminAddQuestion.php'
}
function CheckPassAndGoToAllquestions1() {
  window.location.href = '/displayallrecords.php'
}
function CheckPassAndGoToAllquestions2() {
  window.location.href = '/displayallquestion.php'
}
</script>