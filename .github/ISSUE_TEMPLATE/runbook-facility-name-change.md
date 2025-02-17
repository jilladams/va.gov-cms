---
name: Runbook - Facility name change
about: Steps for updating names and URLs
title: 'Facility name change: <insert_name>'
labels: Change request
assignees: ''

---

## Intake
- [ ] Submitter: <insert_name>
- [ ] If the submitter is an editor, send them the link to the CMS Knowledge Base (KB) article on facility basic data for their product (VAMC or Vet Center). Let them know that facility changes can take between 75 days and 4 months after submitting a request, according to VAST administrators.
- [ ] If the change is a facility closure, send the editor a link to the operating status KB article and have them change the status to Facility notice and provide a description of the facility closure so that Veterans are aware of the future closure.
- [ ] Other stakeholders to include on updates, if any: <insert name>

## Acceptance criteria

- [ ] The H1 title change comes from Lighthouse to Drupal.
- [ ] Coordinate with Facilities team to have FE redirects set up.
- [ ] CMS engineer locates the newly renamed VAMC Facility (https://prod.cms.va.gov/admin/content/bulk) Search by new name
- [ ] CMS engineer updates URL alias for this facility
- [ ] CMS engineer resaves this facility
- [ ] CMS engineer makes bulk alias changes to facility service nodes. (https://prod.cms.va.gov/admin/content/bulk?type=health_care_local_health_service)
- [ ] CMS engineer bulk saves fixed titles to facility service nodes. (https://prod.cms.va.gov/admin/content/bulk?type=health_care_local_health_service)
- [ ] CMS engineer updates menu title for facility
- [ ] CMS engineer updates Alt text for facility image, if relevant.
- [ ] CMS engineer updates Meta description (TBD: some backwards compatibility for SEM, by including something like ", formerly known as [previous name]".
- [ ] CMS engineer edit facility node and remove flag `Changed name` then save node.
- [ ] HD notifies editor and any other stakeholders.
</details>

## Vet Center – facility name change

- [ ] The H1 title change comes from Lighthouse to Drupal.
- Is the new official name plain language (Does it match the pattern <city> Vet Center)?
  - [ ] If yes, update the common name to match (when #6955 Unlock title field on Vet Centers is handled).
- Is the Vet Center published?
  - If yes:
    - [ ] CMS team submits [Redirect request](https://github.com/department-of-veterans-affairs/va.gov-team/issues/new?assignees=mnorthuis&labels=ia&template=redirect-request.md&title=Redirect+Request), cc'ing Facilities team
    - [ ] Once timing of Redirect going live is known, alert CMS engineers to carry out steps in **Update ready** section below
  - If no: CMS engineers may continue with **Update ready** section below
- Update ready
    - [ ] CMS engineer: visit bulk operations page and filter by section = vet center name
    - [ ] CMS engineer: update URLs for all content in that section by bulk operations.
    - [ ] CMS engineer: **if a new section was created** - update field value for section by bulk operations.
    - [ ] CMS engineer: resave all content in that section by bulk operations.
    - [ ] CMS engineer edit Vet Center node and remove flag `Changed name` then save node.
- Is the Vet Center published?
  - [ ] If no, HD notifies Michelle Middaugh to bulk publish.
  - [ ] HD notifies editor and any other stakeholders.
  </details>

## CMS Team
Please check the team(s) that will do this work.

- [ ] `Platform CMS Team`
- [ ] `Sitewide program`
- [ ] `⭐️ Sitewide CMS`
- [ ] `⭐️ Public Websites`
- [x] `⭐️ Facilities`
- [x] `⭐️ User support`
