<script>
// Shared Chart.js plugins
window.drawPercentPlugin = {
  id: 'drawPercent',
  afterDatasetsDraw(chart) {
    const { ctx } = chart;
    const dataset = chart.data?.datasets?.[0];
    if (!dataset) return;
    const total = (dataset.data || []).reduce((a, b) => a + Number(b || 0), 0);
    const meta = chart.getDatasetMeta(0);
    (meta.data || []).forEach((arc, i) => {
      const val = Number(dataset.data?.[i] || 0);
      if (!val || total <= 0) return;
      const pct = (val / total * 100).toFixed(1) + '%';
      const pos = arc.tooltipPosition();
      ctx.save();
      ctx.fillStyle = '#ffffff';
      ctx.font = '700 12px Inter, Arial, sans-serif';
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillText(pct, pos.x, pos.y);
      ctx.restore();
    });
  }
};
</script>