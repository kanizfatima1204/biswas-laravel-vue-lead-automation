<script setup>
import { ref, watch } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';

const props = defineProps({ leads: Array, stats: Object, filters: Object });
const q = ref(props.filters.q || '');
const priority = ref(props.filters.priority || '');
const selected = ref(null);
const showSettings = ref(window.location.hash === '#settings');
let timer;
const form = useForm({ name: '', email: '', service: 'Web Development', urgency: 2, budget: '', source: '' });
watch([q, priority], () => {
  clearTimeout(timer);
  timer = setTimeout(() => router.get('/leads', { q: q.value, priority: priority.value }, { preserveState: true, replace: true }), 250);
});
function submit() { form.post('/leads', { onSuccess: () => form.reset() }); }
function remove(id) { if (confirm('Delete this lead?')) router.delete(`/leads/${id}`); }
</script>

<template>
  <div class="app">
    <aside class="sidebar"><div class="logo-mark">B</div><div class="logo">Biswas <span>IT Firm</span><small>Smart business automation</small></div><nav class="side-nav"><a class="active" href="/leads#dashboard"><i>⌂</i>Dashboard</a><a href="/leads#lead-list"><i>♧</i>Leads</a><a href="/leads#lead-intake"><i>＋</i>Add Lead</a><a href="/leads#lead-list"><i>◉</i>Contacts</a><a href="/leads#settings"><i>⚙</i>Settings</a><Link href="/automation"><i>✦</i>Automation Hunt</Link></nav><div class="sidebar-profile"><span class="avatar">B</span><div><strong>Biswas IT Firm</strong><small>Agency workspace</small></div></div></aside>
    <main id="dashboard">
      <header><div><label>AGENCY OPERATIONS · FINAL CHALLENGE</label><h1>Smart Lead Automation</h1><p>Capture → score → prioritize → prepare a follow-up draft.</p></div></header>
      <div class="cards"><div><small>Total Leads</small><b>{{ stats.total }}</b><em>Database backed</em></div><div><small>Hot Leads</small><b>{{ stats.hot }}</b><em>Priority queue</em></div><div><small>Average Score</small><b>{{ stats.avg }}</b><em>0–100 score</em></div><div><small>Estimated Saved</small><b>{{ stats.saved }}m</b><em>7m per lead estimate</em></div></div>
      <section class="grid">
        <div id="lead-intake" class="panel"><h2>Lead intake</h2><p>Submit a lead to run the scoring and reply-draft workflow.</p><form @submit.prevent="submit">
          <div class="row"><input v-model="form.name" placeholder="Client name"><input v-model="form.email" type="email" placeholder="Email"></div><div class="row"><select v-model="form.service"><option>Web Development</option><option>Digital Marketing</option><option>Graphic Design</option><option>Video Editing</option><option>SEO</option></select><select v-model="form.urgency"><option :value="3">Urgent — this week</option><option :value="2">Normal — this month</option><option :value="1">Flexible</option></select></div><div class="row"><input v-model="form.budget" type="number" min="0" placeholder="Budget USD"><input v-model="form.source" placeholder="Lead source"></div>
          <p v-if="Object.keys(form.errors).length" class="form-error">{{ Object.values(form.errors)[0] }}</p><button :disabled="form.processing">{{ form.processing ? 'Processing…' : 'Run automation' }}</button>
        </form></div>
        <div class="panel"><h2>Automation pipeline</h2><div class="step"><b>01 · Capture</b><small>Validate and store in MySQL</small></div><div class="step"><b>02 · Score</b><small>Budget + urgency + service + referral</small></div><div class="step"><b>03 · Prioritize</b><small>Hot / Warm / Cold</small></div><div class="step"><b>04 · Draft</b><small>Prepare a personalized reply</small></div><div class="step"><b>05 · Track</b><small>Refresh dashboard metrics</small></div><small>Reply requires human review before sending.</small></div>
      </section>
      <section id="lead-list" class="panel table"><div class="head"><div><h2>Recent leads & contacts</h2><p>Search, filter, inspect the generated reply or remove a lead.</p></div><div class="filters"><input v-model="q" placeholder="Search…"><select v-model="priority"><option value="">All priorities</option><option>Hot</option><option>Warm</option><option>Cold</option></select></div></div><div class="scroll"><table><thead><tr><th>Client</th><th>Service</th><th>Budget</th><th>Score</th><th>Priority</th><th>Source</th><th></th></tr></thead><tbody><tr v-for="lead in leads" :key="lead.id"><td><strong>{{ lead.name }}</strong><small>{{ lead.email }}</small></td><td>{{ lead.service }}</td><td>${{ Number(lead.budget).toLocaleString() }}</td><td>{{ lead.score }}</td><td><span :class="['pill', lead.priority.toLowerCase()]">{{ lead.priority }}</span></td><td>{{ lead.source }}</td><td><button class="view" @click="selected = lead">View</button><button class="del" aria-label="Delete lead" @click="remove(lead.id)">×</button></td></tr><tr v-if="!leads.length"><td colspan="7">No leads match these filters yet.</td></tr></tbody></table></div></section>
      <div v-if="selected" class="back" @click.self="selected = null"><div class="modal"><button class="close" @click="selected = null">×</button><label>AUTOMATION RESULT</label><h2>{{ selected.name }}</h2><div class="big">{{ selected.score }}<small>/100</small></div><span :class="['pill', selected.priority.toLowerCase()]">{{ selected.priority }} priority</span><h3>Generated follow-up draft</h3><pre>{{ selected.followup }}</pre><p>Review and personalize this draft before sending externally.</p></div></div>
      <div v-if="showSettings" id="settings" class="back" @click.self="showSettings = false"><div class="modal"><button class="close" @click="showSettings = false">×</button><label>WORKSPACE SETTINGS</label><h2>Lead scoring rules</h2><p>Prototype scoring is currently fixed and transparent:</p><ul class="settings-list"><li>Starting score: 20 points</li><li>Budget: up to 35 points</li><li>Urgency: 10–30 points</li><li>Core service match: 15 points</li><li>Referral source: 10 points</li><li>Hot ≥75 · Warm ≥50 · Cold below 50</li></ul><p>These values are demo defaults. Tune them after reviewing actual won/lost lead outcomes.</p></div></div>
    </main>
  </div>
</template>
