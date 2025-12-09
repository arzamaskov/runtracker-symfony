<script>
	import DashboardLayout from '../../components/dashboard/DashboardLayout.svelte';
	let { children } = $props();
</script>

<DashboardLayout>
	{@render children()}
</DashboardLayout>
