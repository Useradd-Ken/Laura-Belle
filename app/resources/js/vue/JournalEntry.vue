<template>
<JournalHeader @create="openCreateModal" />

<JournalToolbar
    v-model:search="filters.search"
    v-model:status="filters.status"
    v-model:from="filters.from"
    v-model:to="filters.to"
/>

<JournalTable
    :journals="journals"
    :loading="loading"
    @view="viewJournal"
    @edit="editJournal"
    @post="postJournal"
    @void="voidJournal"
    @delete="deleteJournal"
/>

</template>

<script>

import JournalHeader from '../components/JournalEntry/JournalHeader.vue';
import JournalLinesTable from '../components/JournalEntry/componentSquared/JournalLinesTable.vue';
import JournalModal from '../components/JournalEntry/JournalModal.vue';
import JournalToolbar from '../components/JournalEntry/JournalToolbar.vue';
import PostModal from '../components/JournalEntry/PostModal.vue';
import VoidModal from '../components/JournalEntry/VoidModal.vue';



</script>