/// <reference path="../pb_data/types.d.ts" />
migrate((app) => {
  const collection = app.findCollectionByNameOrId("portfolio_items");

  const record0 = new Record(collection);
    record0.set("project_title", "E-commerce Platform");
    record0.set("description", "Modern online store with payment integration");
    record0.set("technologies", ["React", "Node.js", "Stripe"]);
  try {
    app.save(record0);
  } catch (e) {
    if (e.message.includes("Value must be unique")) {
      console.log("Record with unique value already exists, skipping");
    } else {
      throw e;
    }
  }

  const record1 = new Record(collection);
    record1.set("project_title", "Corporate Website");
    record1.set("description", "Professional business website with CMS");
    record1.set("technologies", ["Next.js", "Tailwind", "PostgreSQL"]);
  try {
    app.save(record1);
  } catch (e) {
    if (e.message.includes("Value must be unique")) {
      console.log("Record with unique value already exists, skipping");
    } else {
      throw e;
    }
  }

  const record2 = new Record(collection);
    record2.set("project_title", "Mobile App Landing");
    record2.set("description", "Responsive landing page for mobile app");
    record2.set("technologies", ["React", "Framer Motion", "Tailwind"]);
  try {
    app.save(record2);
  } catch (e) {
    if (e.message.includes("Value must be unique")) {
      console.log("Record with unique value already exists, skipping");
    } else {
      throw e;
    }
  }

  const record3 = new Record(collection);
    record3.set("project_title", "SaaS Dashboard");
    record3.set("description", "Analytics dashboard with real-time data");
    record3.set("technologies", ["React", "Chart.js", "Firebase"]);
  try {
    app.save(record3);
  } catch (e) {
    if (e.message.includes("Value must be unique")) {
      console.log("Record with unique value already exists, skipping");
    } else {
      throw e;
    }
  }

  const record4 = new Record(collection);
    record4.set("project_title", "Blog Platform");
    record4.set("description", "Content management system for bloggers");
    record4.set("technologies", ["Next.js", "Markdown", "MongoDB"]);
  try {
    app.save(record4);
  } catch (e) {
    if (e.message.includes("Value must be unique")) {
      console.log("Record with unique value already exists, skipping");
    } else {
      throw e;
    }
  }

  const record5 = new Record(collection);
    record5.set("project_title", "Portfolio Website");
    record5.set("description", "Creative portfolio showcasing design work");
    record5.set("technologies", ["React", "Three.js", "Tailwind"]);
  try {
    app.save(record5);
  } catch (e) {
    if (e.message.includes("Value must be unique")) {
      console.log("Record with unique value already exists, skipping");
    } else {
      throw e;
    }
  }
}, (app) => {
  // Rollback: record IDs not known, manual cleanup needed
})
